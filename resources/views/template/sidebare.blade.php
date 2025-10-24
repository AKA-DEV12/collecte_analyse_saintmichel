    
@if (Auth::user()->role == 1) 
  <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
         
          <a href="{{route('dashboard')}}" class="text-nowrap logo-img">
            <img src="{{asset('assets/images/logos/favicon.png')}}" width="100px" height="auto" alt="" />
          </a>
      
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('dashboard')}}" aria-expanded="false">
                
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
           
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between has-arrow" href="javascript:void(0)" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-atom"></i>
                  </span>
                  <span class="hide-menu">Collecte de Données</span>
                </div>
                
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
                    href="{{route('collecte.create')}}">
                    <div class="d-flex align-items-center gap-3">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Créer une Collecte</span>
                    </div>
                    
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
                    href="{{route('collecte.index')}}">
                    <div class="d-flex align-items-center gap-3">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Listes</span>
                    </div>
                    
                  </a>
                </li>

              </ul>
            </li>

              <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="{{route('agent.index')}}"
                aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-user-circle"></i>
                  </span>
                  <span class="hide-menu">Agents</span>
                </div>
                
              </a>
            </li>

              <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="{{ route('admin.rendezvous.settings') }}"
                aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                   <i class="ti ti-boombox"></i>
                  </span>
                  <span class="hide-menu">Mes rendez-vous</span>
                </div>
                
              </a>
            </li>
            <li>
              <span class="sidebar-divider lg"></span>
            </li>
    
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>

  @endif