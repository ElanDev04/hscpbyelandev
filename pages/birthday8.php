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
          <img src="../assets/portfolio/birthday8/1.jpg" alt="birthday 1" />
          <img src="../assets/portfolio/birthday8/2.jpg" alt="birthday 2" />
          <img src="../assets/portfolio/birthday8/3.jpg" alt="birthday 3" />
          <img src="../assets/portfolio/birthday8/4.jpg" alt="birthday 4" />
          <img src="../assets/portfolio/birthday8/5.jpg" alt="birthday 5" />
          <img src="../assets/portfolio/birthday8/6.jpg" alt="birthday 6" />
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

