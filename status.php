<?php
// Proves each component can talk to the next one
require_once __DIR__ . '/config/Database.php';
$checks = [];
$checks['Web server (Apache + PHP ' . PHP_VERSION . ')'] = true;
try {
    $db = Database::connect();
    $checks['Application -> Database connection (PDO)'] = true;
    $n = $db->query('SELECT COUNT(*) FROM tblusers')->fetchColumn();
    $checks["Data layer query OK (tblusers has $n rows)"] = true;
} catch (Throwable $e) {
    $checks['Database: ' . $e->getMessage()] = false;
}
?>
<!doctype html><meta charset="utf-8"><title>System status</title>
<style>body{font-family:system-ui;max-width:640px;margin:40px auto;padding:0 16px}
.ok{color:#0a7d2c}.bad{color:#b00020}li{margin:8px 0}</style>
<h2>System communication status</h2>
<ul>
<?php foreach ($checks as $label => $ok): ?>
  <li class="<?= $ok ? 'ok' : 'bad' ?>"><?= $ok ? '✔' : '✘' ?> <?= htmlspecialchars($label) ?></li>
<?php endforeach; ?>
  <li id="api">… Client (browser JS) -> API call</li>
</ul>
<p><a href="index.php">Open the client app</a></p>
<script>
fetch('api/users.php').then(r=>r.json()).then(j=>{
  const el=document.getElementById('api');
  el.className=j.ok?'ok':'bad';
  el.textContent=(j.ok?'✔':'✘')+' Client -> API -> Service -> Repository -> MySQL ('+(j.data?j.data.length:0)+' users returned)';
}).catch(e=>{const el=document.getElementById('api');el.className='bad';el.textContent='✘ API unreachable: '+e;});
</script>
