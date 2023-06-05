@if(auth()->check() && auth()->user()->role === 'admin')
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a class="nav-link active" href="{{ route('admin.products') }}">Products</a>
    <a class="nav-link active" href="{{ route('admin.sellers') }}">Sellers</a>
    <a class="nav-link active" href="{{ route('admin.clients') }}">Clients</a>
  </div>
  @endif
  @if(auth()->check() && auth()->user()->role === 'seller')
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a class="nav-link active" href="{{ route('seller.edit') }}">My Profile</a>
    <a class="nav-link active" href="{{ route('seller.sold') }}">My Sales</a>
  </div>
  @endif
  @if(auth()->check() && auth()->user()->role === 'client')
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a class="nav-link active" href="{{ route('client.edit') }}">My Profile</a>
    <a class="nav-link active" href="{{ route('client.purchases') }}">My Purchases</a>
    <a class="nav-link active" href="{{ route('client.favorites') }}">My Favorites</a>
  </div>
  @endif
  <script>
    
    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginRight = "0";
    }
  
  
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;
  
    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
  </script>