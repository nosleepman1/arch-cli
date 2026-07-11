# Contributing to Arch CLI

Thank you for considering contributing to Arch CLI. Your contributions are vital to improving this tool for the Laravel community.

## Code of Conduct

By participating in this project, you agree to maintain a professional and welcoming environment for all contributors.

## How Can I Contribute?

### Reporting Bugs

Before submitting a bug report, please verify the following:
- You are using the latest version of the package.
- The issue has not already been reported in the GitHub Issues.

When opening an issue, please include:
- A clear and descriptive title.
- Steps to reproduce the behavior.
- Expected vs. actual behavior.
- Relevant environment details (PHP version, Laravel version, OS).
- Stack traces or error logs if applicable.

### Feature Requests

We welcome ideas for new features. When submitting a feature request:
- Explain the use case and why this feature would be beneficial to other developers.
- Describe how you envision the feature working (e.g. command syntax, options).

### Pull Requests

Please follow this process when submitting a Pull Request:

1. Fork the repository and create your branch from `main`.
2. Ensure your code follows the PSR-12 coding standard.
3. Write automated tests for any new features or bug fixes.
4. Run the existing test suite to ensure no regressions are introduced.
5. Update the documentation in the `docs` directory if your changes introduce new commands, options, or behavior.
6. Submit the PR with a clear description of the changes and link to any relevant issues.

## Development Setup

To set up a local development environment:

1. Clone your fork of the repository:
   ```bash
   git clone https://github.com/your-username/arch-cli.git
   cd /path/to/arch-cli
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Run the test suite:
   ```bash
   vendor/bin/phpunit
   ```
