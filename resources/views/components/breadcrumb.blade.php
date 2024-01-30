<style>
.breadcrumb {
    background: white;
    border: 1px;
    border-radius: 5px;
    padding: 10px 0px;
    margin-top: 10px;
    box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
}
li.breadcrumb-item {
    margin-left: 5px;
}
</style>
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        {{Breadcrumbs::render()}}
      {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol> --}}
    </nav>
</div>
