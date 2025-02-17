# OWC Accessible Docs

OWC Accessible Docs is a WordPress plugin that converts uploaded documents (PDF, Word) into HTML pages using NLDoc. The plugin automatically processes files upon upload and generates a page within WordPress which can be validated and provides enhancement suggestions inside the WordPress editor.

## Features

- Automatically creates pages from uploaded documents
- Provides suggestions for improving document accessibility
- Supports a variety of document formats (PDF and Word at the moment)
- Easy integration with your WordPress site

## Installation

1. Upload the plugin files to the `/wp-content/plugins/owc-accessible-docs` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to the plugin settings to configure your preferences.

## Usage

1. Upload your media files to the WordPress media library.
2. The plugin will automatically convert the files and create a WordPress post based on the conversion.
3. From the editor, the validation will take place after an update of the post.
4. Review the accessibility report and follow the suggestions to improve your documents.

## Development

The packages inside the `vendor` directory are namespace-prefixed. This is done by creating a new `vendor-prefixed` directory. After running `composer install`, this process happens automatically: the `vendor-prefixed` directory is generated on the fly, and the original `vendor` directory is deleted after installation.

If you need to work with development dependencies, follow these steps:

1. Run `composer install`. This will remove the `vendor` directory and create the `vendor-prefixed` directory.
2. Run `composer install --no-scripts`. The `--no-scripts` flag prevents the automatic deletion of the `vendor` directory, allowing you to work with the development dependencies. Ensure that the `vendor-prefixed` directory is still present, as the plug-in relies on it.

## License

This plugin is licensed under the GPLv2 or later.

## Support

For support, please visit the [support forum](https://wordpress.org/support/plugin/owc-accessible-docs) or contact us at <support@example.com>.
