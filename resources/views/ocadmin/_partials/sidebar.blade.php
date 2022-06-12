<nav id="column-left">
            <div id="navigation"><span class="fas fa-bars"></span> Navigation</div>
            <ul id="menu">
               <li id="menu-dashboard">
                  <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
               </li>
               <li id="menu-levels">
                  <a href="#collapse-7" data-bs-toggle="collapse" class="parent collapsed"><i class="fas fa-cog"></i> Level 1</a>
                  <ul id="collapse-7" class="collapse">
                     <li><a href="">example</a>
                     </li>
                     <li>
                        <a href="#collapse-7-2" data-bs-toggle="collapse" class="parent collapsed">Level 2</a>
                        <ul id="collapse-7-2" class="collapse">
                           <li><a href="">example</a>
                           </li>
                           <li>
                              <a href="#collapse-7-2-6" data-bs-toggle="collapse" class="parent collapsed">Level 3</a>
                              <ul id="collapse-7-2-6" class="collapse">
                                 <li><a href="http://opencart4x.test/backend/index.php?route=localisation/return_status&amp;user_token=a04539592e4472b5201c41a7e23a6e75">example</a></li>
                                 <li><a href="http://opencart4x.test/backend/index.php?route=localisation/return_action&amp;user_token=a04539592e4472b5201c41a7e23a6e75">example</a></li>
                                 <li><a href="http://opencart4x.test/backend/index.php?route=localisation/return_reason&amp;user_token=a04539592e4472b5201c41a7e23a6e75">example</a></li>
                              </ul>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </li>
            </ul>
            <div id="stats">
               <ul>
                  <li>
                     <div>Orders Completed <span class="float-end">0%</span></div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0%</span></div>
                     </div>
                  </li>
                  <li>
                     <div>Orders Processing <span class="float-end">0%</span></div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0%</span></div>
                     </div>
                  </li>
                  <li>
                     <div>Other Statuses <span class="float-end">0%</span></div>
                     <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span class="sr-only">0%</span></div>
                     </div>
                  </li>
               </ul>
            </div>
         </nav>