<style>
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo {
        width: 100px;
        height: auto;
    }
    .resort-name {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }
</style>

<div class="header">
    <img src="{{ public_path('images/logo new.png') }}" alt="Logo" class="logo">
    <h1 class="resort-name">Lelo's Resort</h1>
    <p>{{ $title ?? 'Report' }}</p>
</div>