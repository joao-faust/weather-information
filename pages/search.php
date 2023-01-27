<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <title>Document</title>
</head>
<body>

  <?php include __DIR__ . '/../includes/navbar.php'; ?>

  <main id="search-main">
    <div class="container border p-3">
      <h5>Search for any city</h5>
      <hr>
      <div class="form-group">
        <label for="city-name">City name</label>
        <input type="text" name="city-name" id="city-name" class="form-control">
      </div>
      <div class="form-group">
        <button class="btn btn-primary" id="search">Search</button>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/../includes/scripts.php'; ?>

  <script>
    const weatherHistory = localStorage.getItem('history')
      ? JSON.parse(localStorage.getItem('history'))
      : [];

    const searchBtn = document.querySelector('#search');
    searchBtn.addEventListener('click', () => {
      const city = document.querySelector('#city-name').value;

      if(!city || city.length === 0){
        return;
      }

      const key = '4fe10470ccdc98ac9e18c97c33730be4';
      const url = `
        https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${key}`;
      fetch(url).then(async (res) => {
        const data = await res.json();

        if(data.cod === '404'){
          const alert = document.createElement('div');
          alert.classList.add('alert', 'alert-danger');
          alert.innerHTML = data.message;
          document.querySelector('.container').appendChild(alert);
          return;
        }

        const date = new Date();
        const year = date.getFullYear();
        const month = date.getMonth()+1<10?`0${date.getMonth()+1}`:date.getMonth()+1;
        const day = date.getDate();
        const hours = date.getHours();
        const minutes = date.getMinutes()<10?`${date.getMinutes()}0`:date.getMinutes();

        const weather = {
          city,
          temp:String(Math.ceil(data.main.temp-273.15)),
          feelsLike:String(Math.ceil(data.main.feels_like-273.15)),
          forecasts:String(data.weather[0].description),
          humidity:String(Math.ceil(data.main.humidity)),
          windSpeed:String(data.wind.speed),
          time:`on ${year}-${month}-${day} at ${hours}:${minutes}`
        }

        weatherHistory.push(weather);
        localStorage.setItem('history', JSON.stringify(weatherHistory));
        window.location.href = `/city-history/${weatherHistory.length-1}`;
      });
    });
  </script>

</body>
</html>
