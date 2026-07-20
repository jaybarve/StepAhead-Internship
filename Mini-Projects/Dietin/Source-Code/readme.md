# DietIn — AI-Powered Diet & Grocery Planner

DietIn is an intelligent web application designed to generate personalized, budget-friendly weekly meal schedules and auto-generate matching grocery lists using Google's Gemini AI engine.

---

## Features

- Tailored Nutrition: Custom meal plans generated based on fitness goals, dietary preferences (Vegetarian, Vegan, Non-Vegetarian), and food likes/dislikes.
- Budget Optimization: Calculates weekly meal portions to strictly honor the user's budget limit.
- Automated Grocery Cart: Auto-converts generated 7-day meal plans into an itemized grocery list with cost estimates.
- Secure Architecture: The Gemini API key is isolated strictly within backend PHP services (cURL), keeping client-side code completely secure.
- Responsive Design: Premium UI featuring a maroon & gold theme, built natively with full mobile and desktop responsiveness.

---

## Tech Stack

- Frontend: HTML5, CSS3 (CSS Variables, Flexbox, CSS Grid), Vanilla JavaScript (Fetch API)
- Backend: PHP (Session handling, RESTful API JSON endpoints, cURL requests)
- AI Engine: Google Gemini API (gemini-1.5-flash)

---

## Project Structure

```text
dietin/
├── css/
│   └── style.css            # Complete design system & responsive styling
├── api/
│   ├── ai_analyze.php       # PHP cURL service communicating with Gemini API
│   └── generate-diet.php    # Session manager & REST endpoint for requests
├── templates/               # Reusable template components
│   ├── header.html
│   └── footer.html
├── index.html               # Landing page
├── generator.html           # Plan configuration form
├── results.html             # Generated diet schedule & grocery cart dashboard
└── support.html             # Customer support & feedback page
