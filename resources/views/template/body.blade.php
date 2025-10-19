@include('template.head')
<body>
   @if(!request()->routeIs('agent.recensement.formulaire'))
  <!--  Body Wrapper -->
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" >
   <!--  App Topstrip -->
    <div class="app-topstrip py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between bg-white">
      <div class="w-30">
       
        <img style="margin-left: 100px;" src="{{asset('assets/images/logos/logo.png')}}" width="30" height="auto" alt="">
        
      </div>

     <div class="d-lg-flex align-items-center gap-3 w-75 p-2 rounded" >
    <h6 style="color: var(--bs-primary)">
        Thème de l'année :
    </h6>
    <div class="flex-grow-1 overflow-hidden">
        <div class="d-inline-block animate-scroll" >
            ÉGLISE FAMILLE DE DIEU À ABIDJAN : SYNODALE, AUTONOME, AU SERVICE DE TOUS.
        </div>
    </div>
</div>

    </div>
    @include('template.sidebare')

 <div class=" {{ auth()->user()->role == 0 ? 'container mt-20' : 'body-wrapper' }}" style="{{ auth()->user()->role == 0 ? 'margin-top: 250px;' : '' }}">
      <!--  Header Start -->
      <header class="app-header" style="{{ auth()->user()->role == 0 ? 'width: 90%;' : '' }}">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            {{-- Notifications --}}
            {{-- <li class="nav-item dropdown">
              <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-bell"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="message-body">
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 1
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 2
                  </a>
                </div>
              </div>
            </li> --}}

            <strong>Collecte & Analyse des Données Paroissiale </strong>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
               
              <li class="nav-item dropdown">
                
                <a class="nav-link " style="font-size: 16px !important; font-weight: bold; display:flex; align-items: center; gap: 16px;" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false"> {{Auth::user()->name}}
                  <img src="{{asset('/assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    {{-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Mon Profil</p>
                    </a> --}}
                   
                   
                    <form action="{{route('logout')}}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">
Deconnexion
                      </button>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
       <div class="body-wrapper-inner">
        <div class="container-fluid">
@endif

    @yield('content')

     </div>
      </div>
 </div>
    @include('template.footer')
  </div>
</body>
</html>