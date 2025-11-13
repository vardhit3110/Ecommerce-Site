<form class="d-flex" id="searchForm" style="margin-left:20px;">
    <input class="form-control me-2" type="search" name="query" id="searchInput" placeholder="Search products..."
        aria-label="Search" autocomplete="off">
    <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
    <div id="searchResult" style="position:absolute; background:white; width:300px; max-height:300px; overflow-y:auto;
              box-shadow:0 4px 8px rgba(0,0,0,0.1); display:none; z-index:9999;"></div>
</form>