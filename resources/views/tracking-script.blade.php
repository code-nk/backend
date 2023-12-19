<script>
(function() {
  // Function to get the user's country using ipinfo.io
  function getUserCountry(callback) {
    fetch('https://ipinfo.io/json')
      .then(response => response.json())
      .then(data => {
        const country = data.country;
        callback(country);
      })
      .catch(error => {
        console.error('Error fetching country:', error);
        callback(null);
      });
  }

  // Function to send the HTTP request
  function sendRequest() {
    // Get data from localStorage or from user's website
    const utm_source = localStorage.getItem('utm_source');
    const utm_medium = localStorage.getItem('utm_medium');
    const utm_content = localStorage.getItem('utm_content');
    const utm_term = localStorage.getItem('utm_term');
    const utm_campaign = localStorage.getItem('utm_campaign');

    // Get document.referrer
    const referrer = document.referrer;

    // Get current date and time
    const dateTime = new Date().toISOString();

    // Get user's country
    getUserCountry(country => {
      // Data to send in the request
      const requestData = {
        utm_source,
        utm_medium,
        utm_content,
        utm_term,
        utm_campaign,
        referrer,
        dateTime,
        country,
      };

      // Send the POST request to your endpoint
      fetch('http://127.0.0.1:8000/api/ping', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestData),
      })
        .then(response => {
          if (response.ok) {
            console.log('Request sent successfully');
          } else {
            console.error('Request failed:', response.statusText);
          }
        })
        .catch(error => {
          console.error('Error sending request:', error);
        });
    });
  }

  // Call the sendRequest function when needed
  sendRequest();
})();
</script>
