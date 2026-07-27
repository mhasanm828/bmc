// info.js
function convertToBangla(input) {
  const bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  return String(input).replace(/\d/g, d => bn[d]);
}

async function loadInfo() {
  const res = await fetch('https://bm-c.vercel.app/info.csv');
  const rows = (await res.text()).trim().split('\n');
  const headers = rows[0].split(',').map(h => h.trim());
  const data = rows.slice(1).map(r => r.split(','));

  const infoMap = {};
  data.forEach(cols => {
    const dept = cols[headers.indexOf('Department')] || 'N/A';
    infoMap[dept] = {
      establish: cols[headers.indexOf('establish')],
      phone: cols[headers.indexOf('phone')],
      email: cols[headers.indexOf('email')],
      direction: cols[headers.indexOf('diraction')],
      maps: cols[headers.indexOf('maps')],
      fb: cols[headers.indexOf('fb')]
    };
  });

  const firstDept = Object.keys(infoMap)[0];
  const info = infoMap[firstDept];

  const hero = document.querySelector('section.relative p');
  if (hero && info.establish) {
    hero.innerHTML += `<br><span class="block mt-2 text-sm">প্রতিষ্ঠাকালঃ ${convertToBangla(info.establish)}</span>`;
  }

  const contact = document.querySelector('#contact .grid');
  if (contact) {
    contact.innerHTML = `
    <div>
      <h3 class="font-semibold text-lg mb-2 text-indigo-700">অবস্থান</h3>
      <p class="text-gray-700">${firstDept.replace('10 - ','')}, সরকারি ব্রজমোহন কলেজ, বরিশাল</p>
      <p class="text-gray-700 mt-2">${info.direction}</p>
      <div class="mt-4">
        <h3 class="font-semibold text-lg mb-2 text-indigo-700">ফোন</h3>
        <p class="text-gray-700">${info.phone}</p>
      </div>
    </div>
    <div>
      <h3 class="font-semibold text-lg mb-2 text-indigo-700">ইমেইল</h3>
      <p class="text-gray-700">${info.email}</p>

      <h3 class="font-semibold text-lg mt-4 mb-2 text-indigo-700">ফেসবুক</h3>
      <a href="${info.fb}" target="_blank" class="text-blue-600 underline">Facebook Link</a>

      <h3 class="font-semibold text-lg mt-4 mb-2 text-indigo-700">লোকেশন</h3>
      <a href="${info.maps}" target="_blank" class="text-blue-600 underline">Google Maps</a>
    </div>`;
  }
}

document.addEventListener('DOMContentLoaded', loadInfo);
