# Ngonlen — Architecture Contract v1

**Tanggal:** 3 Oktober 2026
**Status:** Architecture Baseline
**Purpose:** Kontrak arsitektur untuk development dan implementasi awal Intent-Driven Website Production Engine.

---

## 1. Core Principle

Ngonlen bukan sekadar website builder.

Ngonlen adalah **website production engine** yang memungkinkan user menghasilkan website terutama melalui bahasa natural.

User tidak diwajibkan memahami:

* Page
* Section
* Widget
* Layout
* Component
* Responsive design
* Technical implementation

User cukup menyampaikan intent.

Core flow:

```text
USER
  ↓
INTENT
  ↓
TRANSLATION
  ↓
CLARIFICATION
  ↓
USER CONFIRMATION
  ↓
RENDER
  ↓
WEBSITE
  ↓
┌───────────────────────┐
│                       │
│       "OKE"           │──→ PUBLISH
│                       │
│       "UBAH"          │──→ STUDIO
│                       │
└───────────────────────┘
                         ↓
                       EDIT
                         ↓
                     CANVASSING
                         ↓
                       PUBLISH
```

---

# 2. Fundamental Separation

Sistem memiliki tiga dunia utama:

```text
resources/views/

├── intent/
├── studio/
└── website/
```

### Intent

Memahami apa yang user inginkan.

### Studio

Workspace untuk user yang ingin mengubah hasil secara manual.

### Website

Renderer untuk menghasilkan website dari Website Model.

Ketiganya **tidak boleh dicampur secara tanggung jawab**.

---

# 3. Intent

Intent adalah **input manusia**, bukan struktur website.

Intent harus mampu menerima bahasa yang:

* tidak terstruktur
* ambigu
* singkat
* panjang
* berubah pikiran
* mencampur kebutuhan
* tidak memahami istilah teknis

Contoh:

> "Aku mau website laundry murah di Sidoarjo, yang penting rapi dan orang bisa langsung WhatsApp."

Intent tidak boleh langsung diterjemahkan menjadi Page/Section/Widget.

Flow:

```text
Raw Intent
   ↓
Translation
   ↓
Clarification
   ↓
User Confirmation
```

---

# 4. Translation

Translation mengubah bahasa manusia menjadi **makna website yang terstruktur**.

Translation dapat mengidentifikasi:

```text
- purpose
- business/context
- audience
- desired action
- content needs
- constraints
- budget
- complexity
- explicit requirements
- unknowns
- assumptions
- conflicts
```

Translation **tidak langsung menghasilkan Blade**.

Translation menghasilkan structured intent/specification.

---

# 5. Clarification

Clarification digunakan hanya ketika informasi yang belum jelas **berdampak terhadap hasil website**.

Jangan membuat form panjang hanya untuk mengumpulkan semua kemungkinan informasi.

Prinsip:

```text
UNKNOWN
   ↓
Does it affect the result?
   ├── NO → make a reasonable assumption
   └── YES → ask user
```

Clarification harus menggunakan bahasa manusia.

Bukan:

> `primary_action = whatsapp`

Tetapi:

> "Untuk menerima order, kamu ingin pelanggan langsung chat WhatsApp?"

---

# 6. User Confirmation

Translation tidak boleh dianggap sebagai kebenaran final.

User harus memiliki kesempatan untuk mengatakan:

```text
✓ Sesuai
✎ Ubah
+ Tambahkan
```

Setelah user mengonfirmasi, sistem memiliki **Confirmed Intent**.

Conceptually:

```text
raw_intent
    ↓
translated_intent
    ↓
confirmed_intent
```

Confirmed Intent menjadi dasar pembuatan Website Model.

---

# 7. Intent Does Not Enter Production

Intent adalah bagian dari proses produksi.

Intent **bukan bagian dari website production artifact**.

Production tidak perlu memiliki akses ke:

```text
- raw intent
- translation
- clarification
- confirmation history
```

Production hanya membutuhkan hasil akhirnya:

```text
Website Model
```

Dengan demikian:

```text
INTENT
  ↓
WEBSITE MODEL
  ↓
PRODUCTION
```

Intent tidak menjadi dependency dari production renderer.

---

# 8. Website Model

Website Model adalah hasil konkret dari proses Intent.

Minimal konsepnya:

```text
website
├── theme
├── navigation
├── pages
│   └── sections
│       └── widgets
├── assets
├── integrations
└── settings
```

Intent dapat menjadi sumber pembentukan model ini, tetapi Website Model harus dapat hidup tanpa Intent.

Website Model adalah **artifact utama**.

---

# 9. Page → Section → Widget

Struktur:

```text
Page
└── Section
    └── Widget
```

tetap digunakan.

Namun struktur tersebut adalah **implementasi website**, bukan bahasa utama user.

User tidak perlu berpikir:

> "Saya mau tambah section."

User dapat berkata:

> "Saya mau tambahin bagian harga."

Studio/engine yang menerjemahkan perubahan tersebut menjadi:

```text
Section
└── Widget
```

---

# 10. Section

Section adalah **container**.

Section bukan business logic.

Section digunakan untuk mengelompokkan widget.

Contoh:

```text
Section
├── Heading
├── Text
└── Button
```

Jangan membuat nesting arbitrer yang dalam tanpa kebutuhan nyata.

Default mental model:

```text
Page → Section → Widget
```

---

# 11. Widget

Widget adalah atom visual/content.

Contoh:

```text
heading
text
button
button-group
image
card
table
form
gallery
faq
```

Widget tidak boleh menjadi pusat arsitektur.

Widget adalah **hasil dari kebutuhan website**, bukan sumber kebutuhan website.

---

# 12. Renderer

Renderer adalah satu-satunya sistem yang bertanggung jawab mengubah Website Model menjadi tampilan.

Renderer harus digunakan bersama oleh:

```text
Intent-generated result
Studio canvas
Live website
Export
```

Tidak boleh membuat renderer terpisah untuk:

```text
Studio renderer
Live renderer
Export renderer
```

jika output semantiknya sama.

Prinsip:

```text
             WEBSITE MODEL
                   │
                   ▼
               RENDERER
          ┌────────┼────────┐
          ▼        ▼        ▼
       Preview   Studio    Live
                           │
                           ▼
                       Production
```

---

# 13. Blade Structure

Final Blade architecture:

```text
resources/views/

├── intent/
│   ├── create.blade.php
│   ├── clarify.blade.php
│   └── confirmation.blade.php
│
├── studio/
│   ├── index.blade.php
│   └── components/
│       ├── top-nav.blade.php
│       ├── canvas.blade.php
│       ├── bottom-nav.blade.php
│       ├── bottom-sheet.blade.php
│       └── toast.blade.php
│
└── website/
    ├── shell.blade.php
    ├── page.blade.php
    ├── section.blade.php
    └── widgets/
        ├── heading.blade.php
        ├── text.blade.php
        ├── button.blade.php
        ├── button-group.blade.php
        ├── image.blade.php
        ├── card.blade.php
        ├── table.blade.php
        ├── form.blade.php
        ├── gallery.blade.php
        └── faq.blade.php
```

---

# 14. Studio

Studio adalah **editor**, bukan renderer baru.

Studio menyediakan:

```text
Top Navigation
Canvas
Bottom Navigation
Bottom Sheet
Toast
```

Studio mengubah Website Model.

Studio boleh menggunakan:

```text
Page
Section
Widget
Theme
```

sebagai editing vocabulary.

Namun Studio tetap menggunakan Website Renderer yang sama untuk canvas.

---

# 15. Studio Is Not `pages/`

Studio bukan halaman website.

Studio adalah production tool.

Karena itu:

```text
resources/views/studio/
```

bukan:

```text
resources/views/pages/studio/
```

`pages` hanya merujuk kepada halaman website yang dirender.

---

# 16. Livewire Structure

Livewire mengikuti domain interaction, bukan satu file monster.

```text
app/Livewire/

├── Intent/
│   ├── Create.php
│   ├── Clarify.php
│   └── Confirmation.php
│
└── Studio/
    └── Studio.php
```

Livewire bertanggung jawab atas:

* state
* user interaction
* actions
* transitions

Blade bertanggung jawab atas:

* presentation
* rendering

Domain layer bertanggung jawab atas:

* business rules
* translation
* specification
* planning
* rendering logic
* export

---

# 17. Domain Structure

Prototype:

```text
app/Domain/Website/

├── Intent/
├── Translation/
├── Specification/
├── Rendering/
├── Pages/
├── Sections/
├── Widgets/
├── Themes/
└── Export/
```

Struktur ini dapat berkembang ketika kebutuhan nyata muncul.

Jangan membuat abstraksi atau folder hanya untuk kemungkinan masa depan.

---

# 18. Separation of Responsibilities

```text
USER
 ↓
Intent
 ↓
Translation
 ↓
Clarification
 ↓
Confirmation
 ↓
Website Model
 ↓
Renderer
 ↓
Preview / Studio / Production
```

Responsibility:

```text
Intent
= What does the user want?

Translation
= What does that mean structurally?

Clarification
= What must the user decide?

Confirmation
= Is our interpretation correct?

Website Model
= What are we actually producing?

Renderer
= How is it displayed?

Studio
= How can the user manually modify it?

Production
= Where the final website is published.
```

---

# 19. No Premature AI Complexity

Intent-driven behavior does not require an autonomous AI agent controlling the entire application.

The initial engine may use:

```text
Parsing
+
Normalization
+
Rules
+
Clarification
+
Structured Schema
+
Renderer
```

AI/LLM may assist natural-language translation, but it must not become an uncontrolled dependency for every operation.

The system should remain deterministic wherever possible.

---

# 20. Core UX Principle

The user should experience:

```text
"Ngomong → dipahami → dikonfirmasi → jadi."
```

Not:

```text
"Isi form → pilih template → pilih section → pilih widget → atur layout → ..."
```

Studio exists for users who want more control.

Therefore:

```text
Intent-first
= default path

Studio
= precision path
```

---

# 21. Primary Production Paths

### Fast Path

```text
Intent
 ↓
Translation
 ↓
Confirmation
 ↓
Render
 ↓
Publish
```

### Clarified Path

```text
Intent
 ↓
Translation
 ↓
Clarification
 ↓
Confirmation
 ↓
Render
 ↓
Publish
```

### Editing Path

```text
Intent
 ↓
Translation
 ↓
Clarification
 ↓
Confirmation
 ↓
Render
 ↓
Studio
 ↓
Edit
 ↓
Canvassing
 ↓
Publish
```

---

# 22. Architectural Rule

Never allow a lower-level concept to become the source of truth for a higher-level concept.

Therefore:

```text
Widget ≠ website strategy
Section ≠ website strategy
Page ≠ user intent
Studio ≠ intent
Blade ≠ business logic
Renderer ≠ editor
Production ≠ intent history
```

Direction of dependency:

```text
Intent
  ↓
Translation
  ↓
Specification
  ↓
Website Model
  ↓
Renderer
  ↓
Output
```

Editing may modify the Website Model through Studio.

---

# 23. Current Implementation Goal

The immediate goal is **not** to build the entire Intent AI system.

The immediate goal is to make the architecture ready for it.

Therefore the first implementation should establish:

```text
1. Intent-ready structure
2. Clean Website Model
3. Reusable Website Renderer
4. Studio using the same Renderer
5. Clean separation between Studio and Website
6. No dependency from Production to Intent
```

Do not prematurely implement:

```text
- autonomous agents
- complex AI orchestration
- deep component nesting
- arbitrary page builders
- unnecessary abstraction layers
```

Build the production foundation first.

---

# 24. Final Architecture

```text
                              USER
                               │
                               ▼
                         ┌───────────┐
                         │  INTENT   │
                         └─────┬─────┘
                               ▼
                       ┌───────────────┐
                       │ TRANSLATION   │
                       └───────┬───────┘
                               ▼
                       ┌───────────────┐
                       │ CLARIFICATION │
                       └───────┬───────┘
                               ▼
                       ┌───────────────┐
                       │ CONFIRMATION  │
                       └───────┬───────┘
                               ▼
                       ┌───────────────┐
                       │ WEBSITE MODEL │
                       └───────┬───────┘
                               │
                         ┌─────┴─────┐
                         ▼           ▼
                    ┌────────┐   ┌────────┐
                    │STUDIO  │   │RENDERER│
                    └───┬────┘   └───┬────┘
                        │            │
                        │            ├── Preview
                        │            ├── Live
                        ▼            └── Export
                    Edit Model
                        │
                        ▼
                    CANVASSING
                        │
                        ▼
                    PRODUCTION
```

**This document is the architectural baseline.**

Any agentic implementation should read this contract before modifying the Blade, Livewire, Domain, Renderer, Studio, or Intent architecture.
