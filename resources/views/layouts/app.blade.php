<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Invitium</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root{
      --c1:#795757;
      --c2:#FFF0D1;
      --c3:#A9907E;
      --c4:#FFFFFF;
    }

    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      background:var(--c2);
      color:#222;
    }

    .topbar{
      position:sticky; top:0; z-index:99;
      background:rgba(255,240,209,.95);
      backdrop-filter: blur(6px);
      border-bottom:1px solid rgba(121,87,87,.15);
    }

    .topbar-inner{
      max-width:1100px;
      margin:0 auto;
      padding:14px 18px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
    }

    .brand{
      display:flex; align-items:center; gap:10px;
      font-weight:800; font-size:20px; color:var(--c1);
      text-decoration:none;
    }
    .logo{
      width:36px;height:36px;border-radius:12px;
      background:var(--c1);
      display:inline-flex;
      align-items:center; justify-content:center;
      color:#fff;font-weight:900;
    }

    .nav{
      display:flex; gap:10px; align-items:center;
    }

    .btn{
      padding:10px 14px;
      border-radius:14px;
      border:1px solid rgba(121,87,87,.25);
      background:#fff;
      color:var(--c1);
      text-decoration:none;
      font-weight:700;
      cursor:pointer;
      display:inline-flex;
      align-items:center;
      gap:8px;
      box-shadow:0 8px 16px rgba(121,87,87,.06);
      transition:.15s ease;
    }
    .btn:hover{transform:translateY(-1px)}
    .btn-primary{
      background:var(--c1);
      color:#fff;
      border-color:transparent;
    }
    .btn-ghost{
      background:transparent;
      border-color:rgba(121,87,87,.2);
      box-shadow:none;
    }

    .container{
      max-width:1100px;
      margin:24px auto;
      padding:0 18px;
    }

    .card{
      background:#fff;
      border-radius:24px;
      box-shadow:0 24px 60px rgba(121,87,87,.10);
      overflow:hidden;
      border:1px solid rgba(121,87,87,.10);
    }

    .card-head{
      padding:26px 26px 16px;
      border-bottom:1px solid rgba(121,87,87,.08);
    }
    .card-body{padding:26px}

    h1{margin:0 0 10px; font-size:36px; letter-spacing:-.5px}
    .muted{color:#6b7280; margin:0}

    .table{
      width:100%;
      border-collapse:separate;
      border-spacing:0;
      overflow:hidden;
      border-radius:16px;
      border:1px solid rgba(121,87,87,.12);
    }
    .table th{
      text-align:left;
      background:rgba(169,144,126,.18);
      color:#111;
      padding:14px 16px;
      font-size:14px;
    }
    .table td{
      padding:14px 16px;
      border-top:1px solid rgba(121,87,87,.08);
      vertical-align:top;
    }

    .grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:16px;
    }
    .grid-1{grid-template-columns:1fr}

    label{font-weight:700; color:#111; display:block; margin-bottom:8px}
    input, textarea{
      width:100%;
      padding:12px 14px;
      border-radius:14px;
      border:1px solid rgba(121,87,87,.20);
      outline:none;
      font-size:14px;
      background:#fff;
    }
    textarea{min-height:120px; resize:vertical}

    .section-title{
      margin:0 0 12px;
      font-size:22px;
      color:var(--c1);
      font-weight:900;
    }

    .pill-tabs{
      display:flex;
      gap:10px;
      margin:14px 0 20px;
    }
    .tab{
      padding:10px 14px;
      border-radius:999px;
      border:1px solid rgba(121,87,87,.20);
      background:#fff;
      cursor:pointer;
      font-weight:800;
      color:var(--c1);
    }
    .tab.active{
      background:var(--c1);
      color:#fff;
      border-color:transparent;
    }

    .hidden{display:none!important}

    .row-actions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      margin-top:16px;
    }

    /* modal */
    .modal-backdrop{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.45);
      display:none;
      align-items:center;
      justify-content:center;
      z-index:999;
    }
    .modal{
      background:#fff;
      width:min(420px, 92vw);
      border-radius:22px;
      padding:22px;
      box-shadow:0 30px 90px rgba(0,0,0,.25);
      border:1px solid rgba(121,87,87,.10);
      transform:scale(.98);
      animation:pop .14s ease-out forwards;
    }
    @keyframes pop{
      to{transform:scale(1)}
    }
    .modal h3{
      margin:0 0 6px;
      font-size:20px;
      color:var(--c1);
      font-weight:900;
    }
    .modal p{margin:0 0 16px; color:#444}

    .notice{
      background:rgba(255,240,209,.75);
      border:1px solid rgba(121,87,87,.18);
      padding:12px 14px;
      border-radius:16px;
      margin-bottom:16px;
      color:#5b3f3f;
      font-weight:700;
    }

    @media (max-width:900px){
      .grid{grid-template-columns:1fr}
      h1{font-size:30px}
    }
  </style>
</head>

<body>
  <div class="topbar">
    <div class="topbar-inner">
      <a class="brand" href="{{ route('invitations.index') }}">
        <span class="logo">I</span> Invitium
      </a>

      <div class="nav">
        <a class="btn btn-ghost" href="{{ route('invitations.index') }}">Daftar</a>
        <a class="btn btn-primary" href="{{ route('invitations.create') }}">＋ Buat Undangan</a>
      </div>
    </div>
  </div>

  <div class="container">
    @if($errors->any())
      <div class="notice">
        <div>⚠️ Ada error:</div>
        <ul style="margin:8px 0 0 18px;">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </div>

</body>
</html>
