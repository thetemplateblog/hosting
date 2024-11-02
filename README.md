
# Statamic Hosting Manager

A comprehensive hosting infrastructure management addon for Statamic that helps you manage providers, servers, and sites with a clean, intuitive interface.

![Hosting Manager Screenshot](screenshots/hosting-manager.png)

## Features

### Provider Management
- Secure API key storage with encryption
- Support for major cloud providers:
  - DigitalOcean
  - AWS
  - Linode
  - Vultr
- Easy provider configuration
- API key visibility toggling

### Server Management
- Link servers to configured providers
- Environment tracking (Production/Staging/Development)
- Server status monitoring
- SSH credential management
- Server health indicators

### Site Management
- Domain management
- Server assignment
- Site status tracking
- Environment indicators
- Quick access to site details

## Screenshots

### Provider Management
![Provider Management](screenshots/providers.png)
- Configure hosting providers
- Securely store API credentials
- View provider status

### Server Management
![Server Management](screenshots/servers.png)
- Manage server configurations
- Track server environments
- Monitor server status

### Site Management
![Site Management](screenshots/sites.png)
- Manage hosted sites
- Associate with servers
- Track domains and status

## Installation

You can install this addon via composer:

```bash
composer require thetemplateblog/hosting
```

## Requirements

-   Statamic 4.x
-   PHP 8.1 or higher
-   Laravel 10.x

## Quick Start

1.  Install the addon
2.  Configure your first provider
3.  Add your servers
4.  Start managing your sites

## Detailed Setup

### 1. Provider Configuration

Navigate to  `CP → Hosting → Providers`  and click "Add Provider":

1.  Select your provider type
2.  Enter your provider label
3.  Add your API credentials
4.  Save the provider configuration

### 2. Server Management

Once you have a provider configured, go to  `CP → Hosting → Servers`:

1.  Click "Add Server"
2.  Select your configured provider
3.  Enter server details:
    -   Name
    -   Username
    -   Environment
4.  Save the server configuration

### 3. Site Management

With servers configured, go to  `CP → Hosting → Sites`:

1.  Click "Add Site"
2.  Select the hosting server
3.  Enter site details:
    -   Name
    -   Domain
4.  Save the site configuration

## Configuration

Publish the configuration file:

bash

```
php artisan vendor:publish --tag="hosting-config"
```

### Provider Configuration (`config/hosting.php`)

php

```
return [
    'providers' => [
        [
            'label' => 'DigitalOcean',
            'provider_type' => 'digitalocean',
            'description' => 'DigitalOcean is a cloud infrastructure provider.'
        ],
        [
            'label' => 'AWS',
            'provider_type' => 'aws',
            'description' => 'Amazon Web Services (AWS) is a comprehensive cloud platform.'
        ],
        [
            'label' => 'Linode',
            'provider_type' => 'linode',
            'description' => 'Linode provides simple, affordable, and fast cloud infrastructure.'
        ],
        [
            'label' => 'Vultr',
            'provider_type' => 'vultr',
            'description' => 'Vultr delivers high-performance cloud compute environments.'
        ]
    ]
];
```

## Data Storage

All data is stored securely in the user's YAML file:

-   Provider configurations (with encrypted API keys)
-   Server details
-   Site information

## Security

### API Key Encryption

All API keys are encrypted using Laravel's encryption system before storage.

### Access Control

The addon integrates with Statamic's permission system.

### Data Protection

Sensitive data is stored in secure user YAML files.

## Troubleshooting

### Common Issues

1.  **Provider Not Showing**
    
    -   Check provider configuration
    -   Verify API credentials
2.  **Server Connection Issues**
    
    -   Verify SSH credentials
    -   Check server firewall settings
3.  **Site Management Issues**
    
    -   Confirm server configuration
    -   Verify domain settings

## Development

### Local Development Setup

1.  Clone the repository:

bash

```
git clone https://github.com/thetemplateblog/hosting.git
```

2.  Install dependencies:

bash

```
composer install
```

3.  Link to your Statamic installation:

bash

```
php artisan package:discover
```

### Testing

Run the test suite:

bash

```
composer test
```

## Contributing

Please see  [CONTRIBUTING.md](https://www.typingmind.com/CONTRIBUTING.md)  for details.

## Security

If you discover any security-related issues, please email  [security@example.com](mailto:security@example.com)  instead of using the issue tracker.

Please see  [SECURITY.md](https://www.typingmind.com/SECURITY.md)  for more details.

## Credits

-   [Your Name](https://github.com/yourusername)
-   [All Contributors](https://www.typingmind.com/contributors)

## License

The MIT License (MIT). Please see  [License File](https://www.typingmind.com/LICENSE.md)  for more information.

## Support

### Documentation

Full documentation is available at  [docs.example.com](https://docs.example.com/)

### Issues

Please report issues via the  [GitHub issue tracker](https://github.com/thetemplateblog/hosting/issues)

### Community

Join our  [Discord community](https://discord.gg/example)  for support and discussion

## Roadmap

-   Provider API Integration
-   Automated Server Provisioning
-   Backup Management
-   SSL Certificate Management
-   Site Deployment Automation
-   Server Monitoring
-   Performance Analytics
-   Multi-user Support
