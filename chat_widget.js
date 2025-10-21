// chat_widget.js - widget simple de chat con respuestas a FAQs
(function(){
  const faqs = {
    'horario': 'Nuestro horario es de Lunes a Sábado 8:00 - 20:00.',
    'envios': 'Realizamos envíos a domicilio en la ciudad. El costo depende de la zona.',
    'devoluciones': 'Tienes 7 días para realizar devoluciones con el ticket de compra.',
    'contacto': 'Puedes llamarnos o enviar WhatsApp al 78810097.'
  };

  function createWidget(){
    const btn = document.createElement('div'); btn.className='cw-button'; btn.textContent='Chat';
    document.body.appendChild(btn);

    const panel = document.createElement('div'); panel.className='cw-panel'; panel.style.display='none';
    panel.innerHTML = `
      <div class="cw-header">Ayuda - IC Norte</div>
      <div class="cw-body" id="cw_body">
        <div class="cw-msg bot">Hola, ¿en qué puedo ayudarte? Prueba con preguntas frecuentes o escríbeme.</div>
        <div class="cw-faq">
          <button data-q="horario">Horario</button>
          <button data-q="envios">Envíos</button>
          <button data-q="devoluciones">Devoluciones</button>
          <button data-q="contacto">Contacto</button>
        </div>
      </div>
      <div class="cw-footer">
        <div class="cw-input"><input id="cw_input" placeholder="Escribe tu pregunta..."><button id="cw_send">Enviar</button></div>
      </div>
      <div style="padding:8px;background:#06121a;border-top:1px solid rgba(255,255,255,0.02)">
        <div class="cw-actions">
          <a href="tel:78810097">Llamar 78810097</a>
          <a id="cw_whatsapp" href="#">WhatsApp</a>
        </div>
      </div>
    `;
    document.body.appendChild(panel);

    // eventos
    btn.addEventListener('click', ()=>{ panel.style.display = panel.style.display==='none'?'flex':'none'; panel.style.flexDirection='column'; });
    panel.querySelectorAll('.cw-faq button').forEach(b=> b.addEventListener('click', e=> {
      const q = e.target.getAttribute('data-q'); addUserMsg(q); addBotMsg(faqs[q]||'No encontré una respuesta rápida.');
    }));
    const send = panel.querySelector('#cw_send');
    send.addEventListener('click', ()=>{ const v = panel.querySelector('#cw_input').value.trim(); if(!v) return; addUserMsg(v); handleQuery(v); panel.querySelector('#cw_input').value=''; });
    panel.querySelector('#cw_input').addEventListener('keydown', (ev)=>{ if(ev.key==='Enter'){ ev.preventDefault(); send.click(); }});

    // whatsapp link con mensaje
    const wa = panel.querySelector('#cw_whatsapp');
    const waNum = '78810097';
    wa.href = `https://wa.me/${waNum}?text=${encodeURIComponent('Hola, quiero más información')}`;
    wa.target = '_blank';

    function addUserMsg(text){ const d=document.createElement('div'); d.className='cw-msg user'; d.textContent=text; panel.querySelector('#cw_body').appendChild(d); panel.querySelector('#cw_body').scrollTop=panel.querySelector('#cw_body').scrollHeight; }
    function addBotMsg(text){ const d=document.createElement('div'); d.className='cw-msg bot'; d.textContent=text; panel.querySelector('#cw_body').appendChild(d); panel.querySelector('#cw_body').scrollTop=panel.querySelector('#cw_body').scrollHeight; }

    function handleQuery(q){ const key = q.toLowerCase();
      if(key.includes('horario')) return addBotMsg(faqs['horario']);
      if(key.includes('envio')|| key.includes('envíos')) return addBotMsg(faqs['envios']);
      if(key.includes('devol') ) return addBotMsg(faqs['devoluciones']);
      if(key.includes('contact')|| key.includes('telefono')|| key.includes('whatsapp')) return addBotMsg(faqs['contacto'] + ' Puedes llamar o usar WhatsApp haciendo clic en el botón.');
      // fallback
      addBotMsg('Gracias por tu mensaje. Nuestro equipo te responde en breve. Mientras tanto puedes llamar o usar WhatsApp: 78810097');
    }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', createWidget); else createWidget();
})();
