// course.js
function convertToBangla(input) {
  const bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  return String(input).replace(/\d/g, d => bn[d]);
}

async function loadCourses() {
  const res = await fetch('https://bm-c.vercel.app/course.csv');
  const rows = (await res.text()).trim().split('\n');
  const headers = rows[0].split(',').map(h => h.trim());
  const data = rows.slice(1).map(r => r.split(','));

  const groups = {};
  data.forEach(cols => {
    const dept = cols[headers.indexOf('Department')] || 'N/A';
    const year = cols[headers.indexOf('Year')] || 'N/A';
    const code = cols[headers.indexOf('Course Code')];
    const title = cols[headers.indexOf('Course Title')];
    const credit = cols[headers.indexOf('Credit')];

    const key = `${dept}__${year}`;
    if (!groups[key]) groups[key] = { dept, year, courses: [] };
    groups[key].courses.push({ code, title, credit });
  });

  const container = document.getElementById("courseTables");
  container.innerHTML = '';

  const yearBangla = { "1st":"১ম বর্ষ", "2nd":"২য় বর্ষ", "3rd":"৩য় বর্ষ", "4th":"৪র্থ বর্ষ" };

  Object.values(groups)
    .sort((a,b) => a.dept.localeCompare(b.dept) || a.year.localeCompare(b.year))
    .forEach(({dept, year, courses}) => {
      const title = `${dept.replace('10 - ','')} – ${yearBangla[year]||year}`;
      const sec = document.createElement('div');
      sec.className = "mb-8";
      sec.innerHTML = `
        <h3 class="text-lg font-semibold text-indigo-700 mb-2">${title}</h3>
        <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300">
            <thead class="bg-indigo-100">
              <tr>
                <th class="px-4 py-2 border">কোর্স কোড</th>
                <th class="px-4 py-2 border">কোর্স নাম</th>
                <th class="px-4 py-2 border">ক্রেডিট</th>
              </tr>
            </thead>
            <tbody>
              ${courses.map(c => `
                <tr class="hover:bg-gray-100">
                  <td class="px-4 py-2 border text-center">${c.code}</td>
                  <td class="px-4 py-2 border">${c.title}</td>
                  <td class="px-4 py-2 border text-center">${c.credit}</td>
                </tr>`).join('')}
            </tbody>
          </table>
        </div>`;
      container.appendChild(sec);
    });
}

document.addEventListener('DOMContentLoaded', loadCourses);
