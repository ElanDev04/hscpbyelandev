<!doctype html>
<html lang="en">
   <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Portfolio — ELANDEV'S HSCP</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css" />
  </head>
  <body>
    <div data-include="../includes/header.html"></div>

    <main>
      <section class="section container">
        <h2>Birthday Gallery</h2>
        <p class="muted">A collection of beautiful birthday moments captured by ELANDEV.</p>

        <div class="gallery">
          <img src="../assets/portfolio/birthday4/1.jpg" alt="Birthday 1" />
          <img src="../assets/portfolio/birthday4/2.jpg" alt="Birthday 2" />
          <img src="../assets/portfolio/birthday4/3.jpg" alt="Birthday 3" />
          <img src="../assets/portfolio/birthday4/4.jpg" alt="Birthday 4" />
          <img src="../assets/portfolio/birthday4/5.jpg" alt="Birthday 5" />
          <img src="../assets/portfolio/birthday4/6.jpg" alt="Birthday 6" />
          <img src="../assets/portfolio/birthday4/7.jpg" alt="Birthday 7" />
          <img src="../assets/portfolio/birthday4/8.jpg" alt="Birthday 8" />
          <img src="../assets/portfolio/birthday4/9.jpg" alt="Birthday 9" />
        </div>

        <div class="back-btn">
          <a href="../portfolio.html">← Back to Portfolio</a>
        </div>
      </section>
    </main>

    <div data-include="../includes/footer.html"></div>

    <script>
      document.getElementById('year').textContent = new Date().getFullYear();
    </script>
  </body>
</html>

