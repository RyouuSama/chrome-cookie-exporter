# Cookie Exporter

This project is a simple Chrome extension that exports cookies when you visit a website and sends them to a PHP backend for processing.

## Installation

### Chrome Extension

1. Clone this repository or download the ZIP file and extract it.

```
git clone https://github.com/yourusername/cookie-exporter.git
```

2. Open Chrome and go to `chrome://extensions/`.

3. Enable the "Developer mode" toggle in the top right corner.

4. Click the "Load unpacked" button and select the `chrome-extension` folder from the cloned repository.

The Cookie Exporter extension is now installed and ready to use.

### PHP Backend

1. Make sure you have a PHP server (version 8.2 or newer) set up and running.

2. Upload the `backend` folder to your PHP server.

3. Ensure CORS is enabled on your server to allow communication between the extension and the PHP backend.

## Usage

Once the Chrome extension is installed and the PHP backend is set up, simply visit a website with the extension enabled. The extension will automatically export the cookies and send them to the PHP backend for processing.

## Deployment

To deploy the PHP backend on a live server, follow the instructions provided by your hosting provider to upload the `backend` folder and configure your server for PHP 8.2 or newer.

Make sure to update the `url` variable in the `background.js` file of the Chrome extension to match the URL of your live server.

```javascript
const url = 'https://yourserver.com/cookie_exporter.php';
```