<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <title>Document</title>
</head>
<body>

  <?php include __DIR__ . '/../includes/navbar.php'; ?>

  <main id="solocity-main">
    <div class="container border p-4">
      <h4 id="title" class="mb-3"></h4>
      <div class="px-2">
        <p id="temp"></p>
        <p id="feels-like"></p>
        <p id="forecasts"></p>
        <p id="humidity"></p>
        <p id="windSpeed"></p>
        <p id="date"></p>
      </div>
      <hr>
      <div class="d-flex gap-3">
        <a href="/history">Go history</a>
        <a href="/search">Make another search</a>
        <a href="#" id="remove" class="text-danger">
          <i class="fas fa-trash"></i>
        </a>
      </div>
    </div>
  </main>

  <?php
  $city = filter_input(INPUT_GET, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
  ?>

  <script>
    (() => {
      const index = <?=$city?>;
      if(typeof index === 'undefined' || !localStorage.getItem('history')){
        return;
      }
      const item = JSON.parse(localStorage.getItem('history'))[index];
      if(!item){
        return;
      }

      const capCity = item.city[0].toUpperCase() + item.city.substring(1);
      const title = document.querySelector('#title');
      title.innerHTML = `How was the weather like in ${capCity}`;

      document.querySelector('#temp').innerHTML = `Temperature: ${item.temp}C`;
      document.querySelector('#feels-like').innerHTML = `Feels Like: ${item.feelsLike}C`;
      document.querySelector('#forecasts').innerHTML = `Forecasts: ${item.forecasts}`;
      document.querySelector('#humidity').innerHTML = `Humidity: ${item.humidity}%`;
      document.querySelector('#windSpeed').innerHTML = `Wind Speed: ${item.windSpeed}km/h`;
      document.querySelector('#date').innerHTML = `Date: ${item.time}`;

      const removeBtn = document.querySelector('#remove');
      removeBtn.addEventListener('click', (e) => {
        e.preventDefault();

        const weatherHistory = JSON.parse(localStorage.getItem('history'));
        weatherHistory.splice(index, 1);
        localStorage.setItem('history', JSON.stringify(weatherHistory));
        window.location.href = '/history';
      });
    })();
  </script>

  <?php include __DIR__ . '/../includes/scripts.php'; ?>

</body>
</html>
