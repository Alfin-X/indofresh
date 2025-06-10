<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RunFruitPrediction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:predict-fruit {--force : Force regenerate prediction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run AI fruit prediction based on last month sales data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting AI Fruit Prediction...');
        
        // Check if we should use cached result (unless forced)
        if (!$this->option('force')) {
            $cachedResult = Cache::get('fruit_prediction_result');
            if ($cachedResult) {
                $this->info('Using cached prediction result.');
                $this->displayResult($cachedResult);
                return 0;
            }
        }
        
        try {
            // Check if Python is available
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                $this->error('Python is not available. Please install Python 3.x');
                return 1;
            }
            
            // Check if required Python packages are installed
            $this->info('Checking Python dependencies...');
            if (!$this->checkPythonDependencies($pythonCommand)) {
                $this->error('Required Python packages are missing. Installing...');
                $this->installPythonDependencies($pythonCommand);
            }
            
            // Run the Python prediction script
            $scriptPath = base_path('ai_scripts/fruit_prediction.py');
            
            if (!file_exists($scriptPath)) {
                $this->error("Prediction script not found at: {$scriptPath}");
                return 1;
            }
            
            $this->info('Running AI prediction model...');
            $this->info('This may take a few moments...');
            
            // Execute Python script
            $command = "{$pythonCommand} \"{$scriptPath}\" 2>&1";
            $output = shell_exec($command);
            
            if ($output === null) {
                $this->error('Failed to execute Python script');
                return 1;
            }
            
            // Parse JSON output
            $lines = explode("\n", trim($output));
            $jsonOutput = '';
            $foundJson = false;
            
            // Find JSON output (skip any print statements before JSON)
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '{')) {
                    $foundJson = true;
                }
                if ($foundJson) {
                    $jsonOutput .= $line . "\n";
                }
            }
            
            if (empty($jsonOutput)) {
                $this->error('No JSON output received from Python script');
                $this->error('Raw output: ' . $output);
                return 1;
            }
            
            $result = json_decode($jsonOutput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Invalid JSON output from Python script');
                $this->error('JSON Error: ' . json_last_error_msg());
                $this->error('Raw output: ' . $output);
                return 1;
            }
            
            // Cache the result for 1 hour
            Cache::put('fruit_prediction_result', $result, 3600);
            
            // Log the prediction
            Log::info('AI Fruit Prediction completed', $result);
            
            // Display result
            $this->displayResult($result);
            
            $this->info('Prediction completed successfully!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error running prediction: ' . $e->getMessage());
            Log::error('AI Fruit Prediction failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
    
    /**
     * Get the appropriate Python command
     */
    private function getPythonCommand()
    {
        $commands = ['python3', 'python', 'py'];
        
        foreach ($commands as $cmd) {
            $output = shell_exec("$cmd --version 2>&1");
            if ($output && str_contains($output, 'Python 3')) {
                return $cmd;
            }
        }
        
        return null;
    }
    
    /**
     * Check if required Python packages are installed
     */
    private function checkPythonDependencies($pythonCommand)
    {
        $requiredPackages = [
            'pandas',
            'numpy', 
            'scikit-learn',
            'mysql-connector-python'
        ];
        
        foreach ($requiredPackages as $package) {
            $output = shell_exec("{$pythonCommand} -c \"import {$package}\" 2>&1");
            if ($output !== null && str_contains($output, 'ModuleNotFoundError')) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Install required Python packages
     */
    private function installPythonDependencies($pythonCommand)
    {
        $this->info('Installing required Python packages...');
        
        $packages = [
            'pandas',
            'numpy',
            'scikit-learn',
            'mysql-connector-python'
        ];
        
        foreach ($packages as $package) {
            $this->info("Installing {$package}...");
            $output = shell_exec("{$pythonCommand} -m pip install {$package} 2>&1");
            
            if ($output && str_contains($output, 'Successfully installed')) {
                $this->info("✓ {$package} installed successfully");
            } else {
                $this->warn("⚠ {$package} installation may have failed");
            }
        }
    }
    
    /**
     * Display the prediction result
     */
    private function displayResult($result)
    {
        if ($result['status'] === 'success') {
            $prediction = $result['prediction'];
            
            $this->info('=== AI FRUIT PREDICTION RESULT ===');
            $this->info('');
            $this->info("🍎 Predicted Next Fruit: {$prediction['predicted_fruit']}");
            $this->info("📊 Confidence: " . number_format($prediction['confidence'] * 100, 1) . "%");
            $this->info("💡 Reasoning: {$prediction['reasoning']}");
            $this->info('');
            
            if (!empty($prediction['top_predictions'])) {
                $this->info('📈 Top 3 Predictions:');
                foreach ($prediction['top_predictions'] as $i => $pred) {
                    $rank = $i + 1;
                    $confidence = number_format($pred['confidence'] * 100, 1);
                    $this->info("  {$rank}. {$pred['fruit']} ({$confidence}%)");
                }
                $this->info('');
            }
            
            if (isset($result['data_summary'])) {
                $summary = $result['data_summary'];
                $this->info('📋 Data Summary:');
                $this->info("  • Total Transactions: {$summary['total_transactions']}");
                $this->info("  • Unique Fruits: {$summary['unique_fruits']}");
                if (isset($summary['date_range'])) {
                    $this->info("  • Date Range: {$summary['date_range']['start']} to {$summary['date_range']['end']}");
                }
            }
            
        } else {
            $this->error('=== PREDICTION FAILED ===');
            $this->error("Error: {$result['message']}");
            if (isset($result['prediction']['reasoning'])) {
                $this->error("Details: {$result['prediction']['reasoning']}");
            }
        }
    }
}
