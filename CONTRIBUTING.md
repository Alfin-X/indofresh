# Contributing to IndoFresh

Thank you for considering contributing to IndoFresh! This document outlines the process for contributing to this project.

## Getting Started

1. Fork the repository
2. Clone your fork locally
3. Create a new branch for your feature or bug fix
4. Make your changes
5. Test your changes thoroughly
6. Submit a pull request

## Development Setup

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/SQLite

### Installation
```bash
# Clone the repository
git clone https://github.com/yourusername/indofresh.git
cd indofresh

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

## Code Style

- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Add comments for complex logic
- Write tests for new features

## Pull Request Process

1. Ensure your code follows the project's coding standards
2. Update documentation if necessary
3. Add tests for new functionality
4. Ensure all tests pass
5. Update the CHANGELOG.md if applicable

## Reporting Issues

When reporting issues, please include:
- PHP version
- Laravel version
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)

## Feature Requests

Feature requests are welcome! Please provide:
- Clear description of the feature
- Use case and benefits
- Possible implementation approach

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
