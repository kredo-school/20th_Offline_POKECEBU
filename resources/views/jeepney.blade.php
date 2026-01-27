<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>POKECEBU | Jeepney Finder</title>

  <!-- Leaflet -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  />
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
  ></script>

  <style>
    :root{
      --sec-1:#6FA9DE; --sec-2:#8DBCDA; --sec-3:#51C9D0;
      --acc-1:#96CCB9; --acc-2:#B7E1DA; --acc-3:#FDBF79; --acc-4:#FE9978;
      --cream:#FFFEEF; --sand:#FFF6EE; --border:#E9E3D3;
      --ink:#102433; --muted:#5f6f7f;
      --shadow: 0 18px 55px rgba(20,40,60,.12);
      --radius: 18px;
    }
    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans JP", sans-serif;
      color:var(--ink);
      min-height:100vh;
      background:
        radial-gradient(900px 520px at 15% 10%, rgba(253,191,121,.40), transparent 60%),
        radial-gradient(820px 520px at 90% 15%, rgba(81,201,208,.28), transparent 60%),
        radial-gradient(1000px 520px at 60% 105%, rgba(150,204,185,.32), transparent 60%),
        linear-gradient(180deg, var(--cream) 0%, var(--sand) 55%, #fff 100%);
    }
    .page{ width:min(1080px, 100%); margin:0 auto; padding: 18px 14px 28px; }

    .topbar{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      padding: 12px 14px;
      border: 1px solid rgba(233,227,211,.85);
      background: rgba(255,255,255,.82);
      border-radius: 999px;
      box-shadow: 0 12px 35px rgba(20,40,60,.08);
      backdrop-filter: blur(10px);
    }
    .brand{ display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:.2px; }
    .brand .dot{
      width:10px;height:10px;border-radius:999px;
      background: linear-gradient(135deg, var(--acc-3), var(--acc-4));
      box-shadow: 0 0 0 4px rgba(253,191,121,.22);
    }
    .brand small{ display:block; font-weight:600; color: var(--muted); letter-spacing:0; }

    .container{ margin-top:14px; display:grid; grid-template-rows:auto auto; gap:14px; }

    .mapCard{
      position:relative;
      border-radius: var(--radius);
      overflow:hidden;
      border: 1px solid rgba(233,227,211,.9);
      box-shadow: var(--shadow);
      background: rgba(255,255,255,.7);
    }
    #map{ width:100%; height: 520px; }

    .searchOverlay{
      position:absolute;
      top: 14px;
      left: 14px;
      right: 14px;
      display:flex;
      flex-direction:column;
      gap:10px;
      padding: 10px;
      border-radius: 16px;
      border: 1px solid rgba(233,227,211,.9);
      background: rgba(255,255,255,.92);
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 24px rgba(20,40,60,.10);
    }

    .searchRow{
      display:flex;
      gap:10px;
      align-items:center;
    }

    .searchBox{
      flex: 1;
      display:flex;
      align-items:center;
      gap:10px;
      padding: 10px 12px;
      border-radius: 14px;
      border: 1px solid rgba(233,227,211,.95);
      background: rgba(255,255,255,.95);
    }
    .searchBox input{
      border:0; outline:none; width:100%;
      font-size: 14px; background: transparent; color: var(--ink);
    }
    .searchBox .icon{
      width:18px;height:18px;border-radius:6px;
      display:grid;place-items:center;
      background: linear-gradient(135deg, var(--sec-2), var(--sec-3));
      color:#0b2233; font-weight:900; font-size: 12px;
    }

    .pill{
      border:0; cursor:pointer;
      padding: 10px 12px;
      border-radius: 14px;
      font-weight:800;
      background: linear-gradient(135deg, var(--sec-1), var(--sec-3));
      color:#0b2233;
      box-shadow: 0 10px 20px rgba(111,169,222,.22);
      transition: transform .06s ease, filter .15s ease;
      white-space: nowrap;
    }
    .pill:active{ transform: translateY(1px); }
    .pill.secondary{
      background: linear-gradient(135deg, rgba(253,191,121,.75), rgba(255,238,239,.55));
      border: 1px solid rgba(233,227,211,.9);
      box-shadow:none;
    }

    .chips{
      display:flex;
      flex-wrap:wrap;
      gap:8px;
    }
    .chip{
      cursor:pointer;
      border: 1px solid rgba(233,227,211,.9);
      background: rgba(255,255,255,.88);
      padding: 7px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      color:#0b2233;
      transition: transform .06s ease, background .15s ease;
      user-select:none;
    }
    .chip:hover{ background: rgba(183,225,218,.35); }
    .chip:active{ transform: translateY(1px); }
    .chip.active{
      background: linear-gradient(135deg, rgba(81,201,208,.22), rgba(253,191,121,.22));
      border-color: rgba(81,201,208,.55);
    }

    .details{
      border-radius: var(--radius);
      border: 1px solid rgba(233,227,211,.9);
      box-shadow: var(--shadow);
      background: rgba(255,255,255,.85);
      backdrop-filter: blur(10px);
      padding: 16px;
    }
    .detailsHeader{
      display:flex; align-items:flex-start; justify-content:space-between; gap: 10px;
      margin-bottom: 10px;
    }
    .detailsHeader h2{ margin:0; font-size: 18px; letter-spacing:.2px; }
    .sub{ margin: 4px 0 0; font-size: 13px; color: var(--muted); }

    .routesList{ display:grid; grid-template-columns: 1fr; gap: 10px; margin-top: 10px; }
    .routeItem{
      border: 1px solid rgba(233,227,211,.9);
      border-radius: 14px;
      padding: 12px;
      background: rgba(255,255,255,.92);
      display:flex; align-items:center; justify-content:space-between; gap: 12px;
    }
    .routeLeft{ display:flex; align-items:flex-start; gap: 12px; }
    .routeBadge{
      width: 44px; height: 44px;
      border-radius: 12px;
      display:grid; place-items:center;
      font-weight: 900; color: #0b2233;
      background: linear-gradient(135deg, var(--acc-1), var(--acc-2));
      border: 1px solid rgba(233,227,211,.9);
    }
    .routeMeta h3{ margin:0; font-size: 14px; font-weight: 900; }
    .routeMeta p{ margin: 4px 0 0; font-size: 12px; color: var(--muted); line-height: 1.4; }
    .routeRight{ display:flex; gap: 8px; align-items:center; flex-wrap: wrap; justify-content:flex-end; }
    .tag{
      font-size: 12px; font-weight: 800;
      padding: 6px 10px; border-radius: 999px;
      border: 1px solid rgba(233,227,211,.9);
      background: rgba(183,225,218,.35);
      color:#0b2233;
    }
    .tag.warn{ background: rgba(253,191,121,.35); }

    .empty{
      padding: 14px;
      border-radius: 14px;
      border: 1px dashed rgba(233,227,211,.95);
      color: var(--muted);
      background: rgba(255,255,255,.7);
      font-size: 13px;
    }

    .glowInfo{
      position:absolute;
      bottom: 14px;
      left: 14px;
      right: 14px;
      padding: 10px 12px;
      border-radius: 14px;
      border: 1px solid rgba(233,227,211,.9);
      background: rgba(255,255,255,.88);
      backdrop-filter: blur(10px);
      font-size: 12px;
      color: var(--muted);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap: 10px;
    }
  </style>
</head>

<body>
  <div class="page">
    <div class="topbar">
      <div class="brand">
        <span class="dot"></span>
        <div>
          POKECEBU
          <small>Jeepney Route Finder</small>
        </div>
      </div>
      <button class="pill secondary" id="btnReset">Reset</button>
    </div>

    <div class="container">
      <div class="mapCard">
        <div id="map"></div>

        <div class="searchOverlay">
          <div class="searchRow">
            <div class="searchBox">
              <span class="icon">🔎</span>
              <input id="placeInput" placeholder="Tap a chip below or type: Ayala Center Cebu…" />
            </div>
            <button class="pill" id="btnSearch">Search</button>
          </div>

          <div class="chips" id="chips"></div>
        </div>

        <div class="glowInfo" id="glowInfo">
          <span>Tip: チップを押すと、その周辺を通る路線が光ります。</span>
          <span style="font-weight:800;color:#0b2233;">Demo data</span>
        </div>
      </div>

      <section class="details">
        <div class="detailsHeader">
          <div>
            <h2>Route results</h2>
            <p class="sub" id="subText">チップを押すと、該当路線の詳細がここに表示されます。</p>
          </div>
        </div>
        <div class="routesList" id="routesList">
          <div class="empty">例：<b>Ayala Center Cebu</b> を押してみて。</div>
        </div>
      </section>
    </div>
  </div>

<script>
  // ===== Demo POIs (候補から選ぶ方式に最適) =====
  const POIS = [
    { name: "Ayala Center Cebu", lat: 10.3187, lng: 123.9050 },
    { name: "IT Park (Cebu)", lat: 10.3281, lng: 123.9063 },
    { name: "SM City Cebu", lat: 10.3112, lng: 123.9180 },
    { name: "Carbon Market", lat: 10.2943, lng: 123.8976 },
    { name: "Fuente Osmeña Circle", lat: 10.3093, lng: 123.8923 },
    { name: "Mactan Newtown", lat: 10.3122, lng: 124.0046 },
  ];

  // ===== Demo Routes =====
  const ROUTES = [
    {
      id: "17B",
      name: "Apas–Carbon via Jones (Demo)",
      color: "#51C9D0",
      fare: "₱13–₱18 (est.)",
      notes: "Ayala周辺を通る想定。混雑: 朝夕",
      polyline: [
        [10.3340, 123.9060],
        [10.3281, 123.9063],
        [10.3218, 123.9056],
        [10.3150, 123.9015],
        [10.3093, 123.8923],
        [10.3008, 123.8970],
        [10.2943, 123.8976],
      ]
    },
    {
      id: "04L",
      name: "Lahug–Carbon (Demo)",
      color: "#6FA9DE",
      fare: "₱13–₱18 (est.)",
      notes: "Lahug → Fuente → Carbon っぽい動き",
      polyline: [
        [10.3335, 123.8930],
        [10.3260, 123.8945],
        [10.3187, 123.9050],
        [10.3130, 123.8990],
        [10.3093, 123.8923],
        [10.3006, 123.8965],
        [10.2943, 123.8976],
      ]
    },
    {
      id: "13C",
      name: "SM City–Ayala–Fuente (Demo)",
      color: "#FDBF79",
      fare: "₱13–₱16 (est.)",
      notes: "SM → Ayala → Fuente のイメージ",
      polyline: [
        [10.3112, 123.9180],
        [10.3148, 123.9125],
        [10.3187, 123.9050],
        [10.3138, 123.8998],
        [10.3093, 123.8923],
      ]
    },
    {
      id: "23D",
      name: "Mactan–Cebu City (Demo)",
      color: "#96CCB9",
      fare: "₱15–₱35 (est.)",
      notes: "マクタン側の例（仮）",
      polyline: [
        [10.3122, 124.0046],
        [10.3050, 123.9900],
        [10.3000, 123.9650],
        [10.3040, 123.9400],
        [10.3112, 123.9180],
      ]
    },
  ];

  // ===== Map init =====
  const map = L.map("map").setView([10.3155, 123.9050], 13);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  let placeMarker = null;
  const routeLayers = new Map();

  function baseStyle(route){
    return { color: route.color, weight: 5, opacity: 0.55, lineCap:"round", lineJoin:"round" };
  }
  function highlightStyle(route){
    return { color: route.color, weight: 10, opacity: 0.95 };
  }

  ROUTES.forEach(r => {
    const layer = L.polyline(r.polyline, baseStyle(r)).addTo(map);
    layer.bindTooltip(`${r.id} • ${r.name}`, { sticky:true, direction:"top" });
    layer.on("click", () => {
      setActiveRoutes([r.id], null);
      renderDetails([r], null);
    });
    routeLayers.set(r.id, layer);
  });

  // ===== Chips UI (候補から選ぶ) =====
  const chipsEl = document.getElementById("chips");
  let activePoiName = "";

  function renderChips(){
    chipsEl.innerHTML = POIS.map(p => `
      <div class="chip ${p.name===activePoiName ? "active":""}" data-name="${p.name}">
        ${p.name}
      </div>
    `).join("");
    chipsEl.querySelectorAll(".chip").forEach(el => {
      el.addEventListener("click", () => {
        const name = el.dataset.name;
        document.getElementById("placeInput").value = name;
        activePoiName = name;
        renderChips();
        doSearch(name);
      });
    });
  }
  renderChips();

  // ===== Distance util (demo) =====
  function haversineMeters(lat1, lon1, lat2, lon2) {
    const R = 6371000;
    const toRad = d => d * Math.PI / 180;
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a =
      Math.sin(dLat/2) ** 2 +
      Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon/2) ** 2;
    return 2 * R * Math.asin(Math.sqrt(a));
  }
  function minDistancePointToRouteMeters(point, route){
    let min = Infinity;
    for (const [lat, lng] of route.polyline){
      const d = haversineMeters(point.lat, point.lng, lat, lng);
      if (d < min) min = d;
    }
    return min;
  }

  const THRESHOLD_METERS = 900;

  function findPoiByName(name){
    const s = (name || "").trim().toLowerCase();
    return POIS.find(p => p.name.toLowerCase() === s) || null;
  }

  function focusPoi(poi){
    if (placeMarker) placeMarker.remove();
    placeMarker = L.marker([poi.lat, poi.lng]).addTo(map).bindPopup(`<b>${poi.name}</b>`).openPopup();
    map.setView([poi.lat, poi.lng], 14, { animate:true });
  }

  function setActiveRoutes(routeIds, poi){
    ROUTES.forEach(r => {
      const layer = routeLayers.get(r.id);
      if (layer) layer.setStyle(baseStyle(r));
    });

    routeIds.forEach(id => {
      const route = ROUTES.find(r => r.id === id);
      const layer = routeLayers.get(id);
      if (layer && route) {
        layer.setStyle(highlightStyle(route));
        layer.bringToFront();
      }
    });

    const glowInfo = document.getElementById("glowInfo");
    if (!poi) {
      glowInfo.innerHTML = `<span>Tip: チップを押すと、その周辺を通る路線が光ります。</span><span style="font-weight:800;color:#0b2233;">Demo data</span>`;
      return;
    }
    glowInfo.innerHTML = `
      <span><b>${poi.name}</b> 周辺の路線をハイライト中（${THRESHOLD_METERS}m以内の目安）</span>
      <span style="font-weight:800;color:#0b2233;">${routeIds.length} route(s)</span>
    `;
  }

  function renderDetails(routes, poi){
    const list = document.getElementById("routesList");
    const sub = document.getElementById("subText");

    if (!routes.length){
      list.innerHTML = `<div class="empty">「${poi?.name ?? ""}」付近を通る路線が見つかりませんでした（デモ）。</div>`;
      sub.textContent = poi ? `検索結果：${poi.name} 周辺` : "チップを押すと、該当路線の詳細がここに表示されます。";
      return;
    }

    sub.textContent = poi ? `検索結果：${poi.name} 周辺で見つかった路線` : "選択中の路線";

    list.innerHTML = routes.map(r => `
      <div class="routeItem">
        <div class="routeLeft">
          <div class="routeBadge">${r.id}</div>
          <div class="routeMeta">
            <h3>${r.name}</h3>
            <p>${r.notes}</p>
          </div>
        </div>
        <div class="routeRight">
          <span class="tag">Fare: ${r.fare}</span>
          <span class="tag warn">Click the line</span>
        </div>
      </div>
    `).join("");
  }

  function doSearch(nameFromChip = null){
    const input = document.getElementById("placeInput");
    const name = nameFromChip ?? input.value;
    const poi = findPoiByName(name);

    if (!poi) {
      alert("候補（チップ）から選ぶのがオススメ！デモでは一致する名前のみ検索できます。");
      return;
    }

    activePoiName = poi.name;
    renderChips();
    focusPoi(poi);

    const scored = ROUTES.map(r => ({ route:r, dist:minDistancePointToRouteMeters(poi, r) }))
      .sort((a,b)=>a.dist-b.dist);

    const matched = scored.filter(s => s.dist <= THRESHOLD_METERS).map(s => s.route);

    setActiveRoutes(matched.map(r => r.id), poi);
    renderDetails(matched, poi);

    if (matched.length){
      const group = L.featureGroup([
        ...matched.map(r => routeLayers.get(r.id)),
        placeMarker
      ].filter(Boolean));
      map.fitBounds(group.getBounds().pad(0.2));
    }
  }

  document.getElementById("btnSearch").addEventListener("click", () => doSearch());
  document.getElementById("placeInput").addEventListener("keydown", (e) => {
    if (e.key === "Enter") { e.preventDefault(); doSearch(); }
  });

  document.getElementById("btnReset").addEventListener("click", () => {
    document.getElementById("placeInput").value = "";
    activePoiName = "";
    renderChips();

    if (placeMarker) { placeMarker.remove(); placeMarker = null; }
    setActiveRoutes([], null);
    document.getElementById("subText").textContent = "チップを押すと、該当路線の詳細がここに表示されます。";
    document.getElementById("routesList").innerHTML = `<div class="empty">例：<b>Ayala Center Cebu</b> を押してみて。</div>`;
    map.setView([10.3155, 123.9050], 13);
  });

  setActiveRoutes([], null);
</script>
</body>
</html>
