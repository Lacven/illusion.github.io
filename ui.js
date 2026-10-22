// Navigation and dialog accessibility. Account and payment actions remain in the original module.
document.querySelectorAll('.modal').forEach(modal=>{
 modal.setAttribute('role','dialog');modal.setAttribute('aria-modal','true');
 const heading=modal.querySelector('h2,h3');if(heading){heading.id ||= modal.id+'Title';modal.setAttribute('aria-labelledby',heading.id)}else modal.setAttribute('aria-label','ILLUSION — диалог');
 const close=modal.querySelector('.close-modal');if(close){close.setAttribute('role','button');close.tabIndex=0;close.setAttribute('aria-label','Закрыть');close.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();close.click()}})}
});
let previousFocus;
const observer=new MutationObserver(records=>{for(const record of records){const modal=record.target;if(!modal.classList.contains('modal'))continue;if(modal.classList.contains('active')){previousFocus=document.activeElement;setTimeout(()=>modal.querySelector('input,button,[tabindex="0"],a')?.focus(),30)}else if(!document.querySelector('.modal.active')){document.body.style.overflow='';previousFocus?.focus?.()}}});
document.querySelectorAll('.modal').forEach(m=>observer.observe(m,{attributes:true,attributeFilter:['class']}));
document.addEventListener('keydown',e=>{const active=[...document.querySelectorAll('.modal.active')].at(-1);if(!active)return;if(e.key==='Escape'){active.querySelector('.close-modal')?.click();active.classList.remove('active')}if(e.key==='Tab'){const items=[...active.querySelectorAll('button,a,input,select,textarea,[tabindex="0"]')].filter(x=>x.getClientRects().length&&!x.disabled);const first=items[0],last=items.at(-1);if(e.shiftKey&&document.activeElement===first){e.preventDefault();last?.focus()}else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first?.focus()}}});
document.querySelectorAll('a[target="_blank"]').forEach(a=>a.rel='noopener noreferrer');
