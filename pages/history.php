<!DOCTYPE html>
<html lang="en">
<head>
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <title>Document</title>
</head>
<body>

  <?php include __DIR__ . '/../includes/navbar.php'; ?>

  <header>
    <h3 class="text-center mt-4">History Section</h3>
  </header>

  <main id="history-main">
    <div class="container border p-4">
      <h4 class="mb-3">How was the weather like</h4>
      <hr>
      <div id="history" class="px-2"></div>
      <hr>
      <div>
        <a href="#" id="clear-history">Clear history</a>
      </div>
    </div>
  </main>

  <script>
    (() => {
      if(!localStorage.getItem('history')){
        return;
      }

      const weatherHistory = JSON.parse(localStorage.getItem('history'));
      weatherHistory.forEach((el, index) => {
        const a = document.createElement('a');
        a.href = `city-history/${index}`;
        const capCity = el.city[0].toUpperCase() + el.city.substring(1);
        a.innerHTML = `Was ${el.temp}C in ${capCity} ${el.time}`;

        const p = document.createElement('p');
        p.appendChild(a);
        document.querySelector('#history').appendChild(p);
      });

      const clearHistory = document.querySelector('#clear-history');
      clearHistory.addEventListener('click', (e) => {
        e.preventDefault();
        localStorage.removeItem('history');
        window.location.href = '/history';
      });
    })();
  </script>

  <?php include __DIR__ . '/../includes/scripts.php'; ?>

</body>
</html>
