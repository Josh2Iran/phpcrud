<!doctype html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Client-Server CRUD App</title>
<style>
 body{font-family:system-ui;max-width:900px;margin:30px auto;padding:0 16px;background:#fafafa}
 h1{margin-bottom:4px} .sub{color:#555;margin-top:0}
 form{display:flex;gap:8px;flex-wrap:wrap;margin:16px 0}
 input{padding:8px;border:1px solid #ccc;border-radius:6px;flex:1;min-width:160px}
 button{padding:8px 14px;border:0;border-radius:6px;background:#1a56db;color:#fff;cursor:pointer}
 button.del{background:#c81e1e} button.sec{background:#666}
 table{width:100%;border-collapse:collapse;background:#fff}
 th,td{padding:8px;border-bottom:1px solid #eee;text-align:left}
 #msg{min-height:20px;font-weight:600} .err{color:#b00020} .good{color:#0a7d2c}
 pre{background:#111;color:#9f9;padding:12px;border-radius:8px;max-height:220px;overflow:auto;font-size:12px}
 .arch{background:#fff;border:1px solid #ddd;border-radius:8px;padding:10px 14px;font-size:14px}
</style></head><body>
<h1>Users – Client-Server CRUD App</h1>
<p class="sub">Browser (client) &rarr; PHP API (server) &rarr; MySQL on localhost. <a href="status.php">System status</a></p>

<div class="arch"><b>Layers:</b> 1) Presentation: this page (HTML/JS) &middot; 2) API: <code>api/users.php</code> &middot;
3) Application: <code>UserService</code> &middot; 4) Data: <code>UserRepository</code> + MySQL <code>phpcrud.tblusers</code></div>

<form id="f">
  <input type="hidden" id="id">
  <input id="name" placeholder="Name" required>
  <input id="email" type="email" placeholder="Email" required>
  <button id="save">Add user</button>
  <button type="button" class="sec" onclick="resetForm()">Clear</button>
</form>
<div id="msg"></div>

<table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created</th><th></th></tr></thead><tbody id="rows"></tbody></table>

<h3>Client &harr; Server communication log</h3>
<pre id="log"></pre>

<script>
const API='api/users.php', $=id=>document.getElementById(id);
const esc=s=>String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
function log(line){ $('log').textContent=new Date().toLocaleTimeString()+'  '+line+'\n'+$('log').textContent; }
function say(t,ok=true){ $('msg').className=ok?'good':'err'; $('msg').textContent=t; }

async function call(method,url,body){
  log('REQUEST  '+method+' '+url+(body?' '+JSON.stringify(body):''));
  const r=await fetch(url,{method,headers:{'Content-Type':'application/json'},body:body?JSON.stringify(body):undefined});
  const j=await r.json();
  log('RESPONSE '+r.status+' '+(j.trace?j.trace:JSON.stringify(j)));
  if(!j.ok) throw new Error(j.error||'Request failed');
  return j.data;
}
async function load(){
  try{
    const users=await call('GET',API);
    $('rows').innerHTML=users.map(u=>`<tr><td>${u.id}</td><td>${esc(u.name)}</td><td>${esc(u.email)}</td><td>${esc(u.created_at)}</td>
      <td><button class="sec" onclick="edit(${u.id})">Edit</button> <button class="del" onclick="del(${u.id})">Delete</button></td></tr>`).join('');
  }catch(e){ say(e.message,false); }
}
$('f').addEventListener('submit',async ev=>{
  ev.preventDefault();
  const id=$('id').value, body={name:$('name').value,email:$('email').value};
  try{
    await (id?call('PUT',API+'?id='+id,body):call('POST',API,body));
    say(id?'User updated.':'User created.'); resetForm(); load();
  }catch(e){ say(e.message,false); }
});
async function edit(id){
  try{ const u=await call('GET',API+'?id='+id);
    $('id').value=u.id; $('name').value=u.name; $('email').value=u.email; $('save').textContent='Update user';
  }catch(e){ say(e.message,false); }
}
async function del(id){
  if(!confirm('Delete user '+id+'?')) return;
  try{ await call('DELETE',API+'?id='+id); say('User deleted.'); load(); }catch(e){ say(e.message,false); }
}
function resetForm(){ $('f').reset(); $('id').value=''; $('save').textContent='Add user'; }
load();
</script></body></html>
