const botToken = "7957591127:AAF-mbiHrYaGZK72EiWzSsT_8N9kl_CNGPo";
const chatId = "5507924419";

// 🔁 Get last serial from localStorage or start at 1
let serial = parseInt(localStorage.getItem("serialNumber")) || 1;

async function getPdf() {
  const phone = document.getElementById("phone").value.trim();
  const error = document.getElementById("error");

  // ✅ Validate phone number
  if (!/^01\d{9}$/.test(phone)) {
    error.textContent = "Please enter a valid 11-digit Bangladeshi phone number.";
    error.classList.remove("hidden");
    return;
  }
  error.classList.add("hidden");

  // 🌍 Get IP address
  let ip = "Unavailable";
  try {
    const ipRes = await fetch("https://api.ipify.org?format=json");
    const ipData = await ipRes.json();
    ip = ipData.ip;
  } catch (e) {}

  // 📆 Time and date
  const now = new Date();
  const fullDate = now.toLocaleDateString();
  const time = now.toLocaleTimeString();

  // 📎 Links
  const admitUrl = `https://e-laeltd.com/apply-pdf?view=${phone}`;
  const waUrl = `https://wa.me/+88${phone}`;
  const tgUrl = `https://t.me/+88${phone}`;
  const siteUrl = window.location.href;

  // 📝 Message format
  const msg = `📥
E-learning and Earning Project

*New Download Request*

🔢 Serial: ${serial}
📱 Phone: ${phone}
🔗 Admit: ${admitUrl}

🌍 IP: ${ip}
📅 Date: ${fullDate}
⏰ Time: ${time}
🔗 Site: ${siteUrl}

📞 WhatsApp: ${waUrl}
📨 Telegram: ${tgUrl}

Thanks ❤️‍🩹.`;

  // 🚀 Send to Telegram
  fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      chat_id: chatId,
      text: msg,
      parse_mode: "Markdown"
    })
  });

  // ➕ Save updated serial
  serial++;
  localStorage.setItem("serialNumber", serial);

  // 🔗 Open PDF
  window.open(admitUrl, "_blank");
}