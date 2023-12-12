<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap-->
  <link href="/StreamSync/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="...">
  <link rel="stylesheet" href="/StreamSync/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" integrity="...">
  <script src="/StreamSync/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="src/assets/css/index.css">

  <title>StreamSync</title>
</head>

<body>

  <nav class="navbar w-100 position-fixed top-0 bot-0 navbar-expand-lg navbar-dark">
    <a class="navbar-brand ms-5">
      <img src="src/assets/images/logo.png" alt="StreamSync Logo" height="36" />
    </a>

    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav justify-content-center align-items-center fs-5 flex-grow-1 pe-3">
        <div class=" position-relative d-flex flex-row justify-content-end align-items-start">
          <li class="nav-item mx-2">
            <a class="nav-link active fs-6" aria-current="page" href="#home">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link fs-6" href="#recomendacoes">Recomendações</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link fs-6" href="#services">Serviços</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link fs-6" href="#sobre">Sobre Nós</a>
          </li>
        </div>
      </ul>

      <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-3 me-5 ">
        <a href="src/views/public/login.php" class="btn-sign-up  w-100 text-align-center text-white text-decoration-none px-3 py-1 rounded-4 ms-3">Login</a>
      </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-end bg-black " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header text-white border-bottom">
      <h5 class="offcanvas-title" id="offcanvasNavbarLabel">StreamSync</h5>
      <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-4 p-lg-0 text-white ">
      <ul class="navbar-nav  align-items-center fs-5 flex-grow-1 pe-3 d-flex flex-column justify-content-center align-items-center">
        <div class=" position-relative d-flex flex-column align-items-center">
          <li class="nav-item mx-2">
            <a class="nav-link active" aria-current="page" href="#home">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link " href="#recomendacoes">Recomendações</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link " href="#services">Serviços</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="#sobre">Sobre Nós</a>
          </li>
        </div>
      </ul>



      <div class="d-flex flex-column justify-content-center align-items-center gap-3 mb-5">
        <a href="src/views/public/login.php" class="btn-sign-up  w-50 text-center text-white text-decoration-none py-1 rounded-4">Login</a>
      </div>
    </div>
  </div>
  </div>

  <main>

    <section id="home" class="position-relative">
      <img src="src/assets/images/background.jpg" class="img-fluid h-100 w-100 z-index-negative-1 opacity-75 object-fit-cover" alt="Background">
      <div class="hero-home__item position-absolute top-0 start-0 w-100 h-100 px-1 ">
        <div class="d-flex flex-column justify-content-center align-items-center h-100 text-white text-center">
          <img src="src/assets/images/logo.png" class="img-fluid mx-auto d-block mb-3 mt-5 " width="400" alt="Logo">
          <h1 class=" display-5 font-weight-bold mb-3">Explore, compartilhe e gerencie os seus
            filmes e séries favoritos</h1>
          <p class=" lead mb-3">Faça parte da nossa comunidade de entusiastas do cinema
            e
            TV.<br>
            Organize e compartilhe a sua coleção, classifique, comente e conecte-se com outros amantes do
            entretenimento. <br>Registe-se agora para começar a compartilhar a magia do cinema e da TV.
          </p>
          <div class="mt-5">
            <a class="btn btn-danger btn-lg btn-block" href="src/views/public/register.php" role="button">
              <span class="">Comece Já</span>
            </a>
          </div>
        </div>
    </section>

    <section id="recomendacoes" class="h-auto ">
      <div class="container">
        <div class="d-flex align-items-center justify-content-center text-white">
          <div class="row mt-5">
            <div class="w-100 mx-auto mt-5">
              <h1 class=" text-center mb-3 display-10 fw-bold pb-2 border-bottom">
                Recomendações</h1>
            </div>
            <h2 class="">Movies</h2>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/interstellar.jpg" class="hero-list__img mt-3 rounded " alt="interstellar" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">
                  Assistir Online
                </button>
              </div>
              <p class="overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Interstellar</p>
              <div class="d-flex justify-content-between gap-4">
                <p class="m-0">2014</p>
                <span><i class="fab fa-imdb"> &nbsp;8.7</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/five_nights_at_freddy's.jpg" class="hero-list__img mt-3 rounded " alt="Five Nights at Freddy's" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Five Nights
                at
                Freddy's</p>
              <div class="d-flex justify-content-between gap-4">
                <p class="m-0">2023</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;5.5</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/o_padrinho.jpg" class="hero-list__img mt-3 rounded " alt="The Godfather" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">The Godfather</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">1972</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;9.2</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/senhor_dos_aneis.jpg" class="hero-list__img mt-3 rounded " alt="Shrek 2" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">O Senhor dos Anéis
              </p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2003</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;7.3</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/shrek2.jpg" class="hero-list__img mt-3 rounded " alt="Shrek 2" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Shrek 2</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2004</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;7.3</i></span>
              </div>
            </div>


            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/movies/the_intouchables.jpeg" class="hero-list__img mt-3 rounded " alt="The Intouchables" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">The Intouchable</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2011</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;8.5</i></span>
              </div>
            </div>

          </div>
        </div>


        <div class="text-white">
          <div class="row mt-5">
            <h2 class="">Series</h2>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/The_100.jpg" class="hero-list__img  mt-3 rounded " alt="The 100" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">The 100</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2014</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;7.6</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/vikings.jpg" class="hero-list__img  mt-3 rounded " alt="Vikings" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Vikings</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2013</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;8.5</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/the_mandalorian.jpg" class="hero-list__img  mt-3 rounded " alt="The Mandalorian" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">The Mandalorian</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2019 </p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;8.7</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/see.jpeg" class="hero-list__img  mt-3 rounded " alt="See" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">See</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2019</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;7.6</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/vis_a_vis.png" class="hero-list__img  mt-3 rounded " alt="Vis a Vis" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Vis a Vis</p>
              <div class=" d-flex justify-content-between gap-4">
                <p class="m-0">2015</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;8.1</i></span>
              </div>
            </div>

            <div class="d-flex flex-column align-items-center text-center col-6 col-sm-6 col-md-4 col-lg-2">
              <div class="hero-list__movie position-relative">
                <img src="src/assets/images/overlays/series/peaky_blinders.jpg" class="hero-list__img  mt-3 rounded " alt="Peaky Blinders" />
                <button class="watch-button position-absolute top-50 start-50 translate-middle text-nowrap border-0 text-black rounded-4">Assistir
                  Online</button>
              </div>
              <p class=" overflow-hidden text-nowrap d-inline-block text-truncate w-75 m-0">Peaky Blinders</p>
              <div class=" d-flex justify-content-between gap-4 mb-4">
                <p class="m-0">2013</p>
                <span><i class="imdb-icon fab fa-imdb"> &nbsp;8.8</i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="services">
      <div class="d-flex justify-content-center align-items-center text-white">
        <div class="container mt-5">
          <div class="w-100 mx-auto mt-5">
            <h1 class=" text-center mb-3 display-10 fw-bold pb-2 border-bottom">
              Serviços</h1>
          </div>

          <div class="row hero-features-row d-flex justify-content-center align-items-center">
            <div class="col-12 col-sm-6 col-md-4">
              <img src="src/assets/images/REVIEW MOCKUP.png" class="w-100 h-auto" alt="review and rating  " />
            </div>
            <div class="col-12 col-sm-6 col-md-8">
              <h2 class=" text-justify font-weight-bold">Compartilhe a sua paixão pelo cinema</h2>
              <p class="text-justify ">As suas críticas e as suas avaliações ajudam a trazer a Magia do
                Cinema à Vida!
                Descubra o que os nossos utilizadores tem a dizer a cerca da sua próxima experiência cinematográfica
                com
                confiança e ajude a construir esta comunidade fazendo as suas próprias críticas e avaliações das suas
                experiências.</p>
            </div>
          </div>

          <div class="row hero-features-row d-flex justify-content-center align-items-center border-top mt-4">
            <div class=" col-12 col-sm-6 col-md-8">
              <h2 class=" text-justify font-weight-bold">Faça a sua avaliação a qualquer hora e lugar</h2>
              <p class=" text-justify">Oferecemos lhe a possibilidade de realizar as suas críticas e as
                suas
                avaliações a
                qualquer momento
                e em qualquer lugar. A nossa plataforma é multiplataforma e está disponível para todos os
                dispositivos móveis e computadores.
              </p>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <img src="src/assets/images/multiplataform-mockup.png" class="w-100 h-auto ms-4" alt="review and rating  " />
            </div>
          </div>

          <div class="row hero-features-row d-flex justify-content-center align-items-center border-top mt-4">
            <div class=" col-12 col-sm-6 col-md-4 ">
              <img src="src/assets/images/watch-after mockup.png" class="w-100 h-auto" alt="review and rating " />
            </div>
            <div class="col-12 col-sm-6 col-md-8">
              <h2 class=" text-justify font-weight-bold">Agende a data para ver o seu filme e deixe a
                diversão
                ser inesquecível!
              </h2>
              <p class=" text-justify">Não perca a chance de viver uma experiência cinematográfica
                incrível.
                Agende a data
                para o seu filme e
                crie memórias que durarão para sempre.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="sobre" class="py-3 py-md-5 py-xl-8">
      <div class="container">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-center">
          <div class="col-12 col-lg-6 col-xl-5">
            <img class="img-fluid rounded mx-auto d-block" loading="lazy" src="src/assets/images/about_us.png" alt="" width="80%">
          </div>
          <div class="col-12 col-lg-6 col-xl-7">
            <div class="row justify-content-xl-center">
              <div class="col-12 col-xl-11 text-white">
                <h2 class=" h1 mb-3">Sobre Nós</h2>
                <p class=" lead fs-4 text-secondary mb-3 text-white">Simplificamos a gestão de filmes e séries,
                  oferecendo uma experiência envolvente e única.</p>
                <p class=" mb-5">A StreamSync é um projeto desenvolvido por dois estudantes de engenharia informática,
                  que tem como objetivo simplificar a organização e a partilha das suas experiências cinematográficas.
                  Com a possibilidade de criar contas individuais, gerir perfis, categorizar e partilhar, oferecemos uma
                  abordagem colaborativa única. Facilitamos a busca por filmes e séries específicos, permitindo
                  adicionar anexos, classificações e comentários. </br></br>
                  Junte-se a nós nessa jornada de descobertas cinematográficas!</p>
                <div class="row gy-4 gy-md-0 gx-xxl-5X">
                  <div class="col-12 col-md-6">
                    <div class="d-flex">
                      <div class="me-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                          <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                        </svg>
                      </div>
                      <div>
                        <h4 class=" mb-3">Versatilidade Cinematográfica</h4>
                        <p class=" text-secondary mb-0">Descomplicamos a gestão de filmes e séries, proporcionando uma
                          experiência versátil em qualquer dispositivo.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="d-flex">
                      <div class="me-4 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                          <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                        </svg>
                      </div>
                      <div>
                        <h4 class=" mb-3">Plataforma Audiovisual</h4>
                        <p class=" text-secondary mb-0">Integramos a simplicidade com conceitos distintos, proporcionando
                          uma experiência singular na gestão de filmes e séries.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="position-relative d-flex flex-column flex-sm-row justify-content-between align-items-center text-white w-100 h-100 p-4">

    <p class=" mb-3 mb-sm-0">2023 StreamSync &copy</p>

    <a href="/" class="mb-3 mb-sm-0 link-dark text-decoration-none">
      <img src="src/assets/images/logo.png" alt="MovieBiz Logo" height="36" />
    </a>

    <ul class="nav footer-social-icons justify-content-center list-unstyled d-flex mb-3 mb-sm-0">
      <li class="">
        <a href="https://twitter.com/SSync27157">
          <i class="bi bi-twitter text-white"></i>
        </a>
      </li>
      <li class="ms-3">
        <a href="https://www.instagram.com/streamsync_/">
          <i class="bi bi-instagram text-white"></i>
        </a>
      </li>
      <li class="ms-3">
        <a href="https://github.com/DiogoBernardes/Movies-and-or-Series-Management">
          <i class="bi bi-github text-white"></i>
        </a>
      </li>
    </ul>
  </footer>

</body>

</html>