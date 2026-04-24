# Boud AI Free Plan Blueprint - 2026-04-24

## الهدف

هذه النسخة تكمل باقة `Free` بشكل تنفيذي جاهز للإدخال في لوحة الإدارة، مع ربط مباشر بين:

- حقول الباقة الموجودة فعليًا في النظام
- مفاتيح الصلاحيات التي ظهرت في الكود الحالي
- اتجاه المنتج المذكور في `handoff`

النتيجة المطلوبة من `Free`:

- تجربة واضحة جدًا
- أقل تكلفة تشغيل ممكنة
- تحويل المستخدم إلى `Creator`
- منع الوصول إلى الأدوات الثقيلة حتى لو كانت الإضافة مثبتة داخل المشروع

---

## قرار الإطلاق الحالي

### التوصية

ابقِ باقة `Free` **مخفية حاليًا**:

- `hidden = true`

### السبب

- `Creator` و `Pro` و `Agency` ما زالت غير مكتملة تجاريًا
- إظهار التسعير الآن سيُظهر هيكلًا غير جاهز للمستخدم النهائي
- إكمال `Free` الآن مفيد تقنيًا، لكن **لا أنصح بجعلها مرئية للمستخدمين قبل إنهاء Creator و Pro على الأقل**

---

## قيم الحقول المقترحة في لوحة الإدارة

## Step 1 - Global Settings

| الحقل | القيمة المقترحة |
|---|---|
| `active` | `true` |
| `name` | `Free` |
| `description` | `ابدأ مجانًا لتجربة Boud AI في الشات والكتابة وصناعة المحتوى الأساسي قبل الترقية إلى Creator.` |
| `features` | `AI Chat أساسي, AI Writing أساسي, Templates محدودة, صور أساسية محدودة, مستندات محدودة, بدون فريق` |
| `default_ai_model` | `gpt-5-mini` |
| `plan_type` | `regular` |
| `is_featured` | `false` |

### ملاحظات

- اختيار `gpt-5-mini` هو الخيار الأكثر أمانًا هنا لأنه منسجم مع المنطق الافتراضي الحالي في النظام.
- إذا أردت لاحقًا تقليل التكلفة أكثر، يمكن اختبار التحويل إلى `deepseek-chat` أو `gemini-3-flash` بعد مراجعة جودة المخرجات الفعلية.

## Step 1 - Pricing

| الحقل | القيمة المقترحة |
|---|---|
| `price` | `0` |
| `price_tax_included` | `true` |
| `frequency` | `monthly` |
| `is_team_plan` | `false` |
| `plan_allow_seat` | `0` |
| `trial_days` | `0` |
| `affiliate_status` | `false` |
| `reset_credits_on_renewal` | `true` |

### ملاحظات

- لأن الوثائق الحالية تتحدث عن **حدود شهرية**، فالأفضل أن تبقى `Free` شهرية مع `reset_credits_on_renewal = true`.
- لا أنصح بتمكين الفريق أو المقاعد أو برنامج الإحالة داخل الخطة المجانية.

## Chatbot / Agent / Voice Limits

| الحقل | القيمة المقترحة |
|---|---|
| `chatbot_limit` | `0` |
| `chatbot_human_agent` | `false` |
| `chatbot_channels.telegram` | `false` |
| `chatbot_channels.whatsapp` | `false` |
| `chatbot_channels.messenger` | `false` |
| `chatbot_channels.instagram` | `false` |
| `social_media_agent_limits.agents` | `0` |
| `social_media_agent_limits.monthly_posts` | `0` |
| `blogpilot_limits.agents` | `0` |
| `blogpilot_limits.monthly_posts` | `0` |
| `voice_call_seconds_limit` | `0` |

### ملاحظات

- في كود `SocialMediaAgent` و `BlogPilot`، القيمة `0` تعني المنع الكامل، بينما `-1` تعني غير محدود.
- لهذا السبب يجب أن تكون حدود الوكلاء والمدونات والصوت `0` في باقة `Free`.

## Step 3 - Private Configuration

| الحقل | القيمة المقترحة |
|---|---|
| `hidden` | `true` |
| `max_subscribe` | `-1` |
| `last_date` | `null` |
| `hidden_url` | تلقائي من النظام |

### ملاحظات

- استخدم `-1` لأن `0` في المنطق الحالي تعني أن الاكتتاب متوقف.
- اترك `last_date` فارغًا حتى لا تنتهي الخطة تلقائيًا.

## Multi-model

| الحقل | القيمة المقترحة |
|---|---|
| `multi_model_support` | `false` |
| `user_api` | `false` |

---

## مفاتيح الصلاحيات المقترحة لباقة Free

## ما يتم تفعيله في `plan_ai_tools`

فعّل فقط المفاتيح التالية:

- `ai_writer`
- `ai_editor`
- `ai_chat_all`
- `ai_rewriter`
- `support`

### خيار إضافي بحذر

إذا أردت الالتزام الحرفي بالوثائق التي تسمح بـ "صور قليلة جدًا"، فعّل:

- `ai_image_generator`

لكن إذا كان هدف الإطلاق الأول هو أقل تكلفة ممكنة، فاتركه مغلقًا الآن وانقله إلى `Creator`.

## ما يتم إيقافه في `plan_ai_tools`

أوقف صراحة هذه المفاتيح في `Free`:

- `ai_image_pro`
- `ai_chat_pro_image_chat`
- `ai_pdf`
- `ai_vision`
- `ai_speech_to_text`
- `ai_voiceover`
- `ai_voiceover_clone`
- `ai_voice_isolator`
- `ai_video`
- `ai_presentation`
- `ai_social_media_extension`
- `ext_social_media_dropdown`
- `ext_social_media_agent_dropdown`
- `ext_blogpilot_dropdown`
- `ext_chat_bot`
- `ext_voice_chatbot`
- `ext_ai_music_pro`
- `creative_suite`
- `brand_voice`
- `url_to_video`
- `viral_clips`
- `influencer_avatar`
- `ai_influencer`
- `marketing_bot`
- `marketing_bot_dashboard`
- `marketing_bot_settings`
- `marketing_bot_inbox`
- `marketing_bot_campaigns`
- `marketing_bot_telegram`
- `marketing_bot_whatsapp`

## ما يتم تفعيله في `plan_features`

فعّل فقط:

- `support`

واترك هذه المفاتيح مغلقة:

- `api_keys`
- `brand_voice`
- `integration`
- `custom_templates_extension`
- `chat_training_extension`
- `creative_suite`
- `ai_influencer`
- `url_to_video`
- `viral_clips`
- `influencer_avatar`

---

## Template Access - Step 3

بسبب تعذر قراءة قاعدة البيانات المحلية من هذا الـ workspace، لا يمكنني استخراج قائمة `open_ai_items` الحالية من جدول `plans` مباشرة. لذلك التوصية التنفيذية هنا هي:

### فعّل فقط القوالب منخفضة التكلفة والقريبة من الاستخدام الأول

- كتابة عامة
- إعادة صياغة / اختصار / تحسين نص
- وصف منتج بسيط
- عنوان أو وصف بريد
- منشور قصير بسيط
- محادثة أساسية

### أوقف القوالب أو الأدوات التالية داخل `open_ai_items`

- أي شيء متعلق بالفيديو
- أي شيء متعلق بالصوت
- `ai_article_wizard`
- `ai_detector_extension`
- `ai_plagiarism_extension`
- `ai_web_chat_extension`
- `ai_chat_pro_image_chat`
- `ai_presentation`
- `ai_social_media_extension`
- `ext_chat_bot`
- `ext_social_media_agent_dropdown`
- `ext_blogpilot_dropdown`
- جميع مفاتيح `marketing_bot*`

### أفضل طريقة عملية

ابدأ من قائمة `free_open_ai_items` الحالية داخل الإعدادات إن كانت مضبوطة، ثم:

- أبقِ الكتابة والشات فقط
- احذف كل ما يقود إلى social / agents / chatbot / voice / video / premium image

---

## الحدود التشغيلية المقترحة

هذه القيم ليست أعمدة مباشرة داخل `plans`، لكنها المرجع الذي يجب أن تُترجم إليه في شاشة الـ credits:

| البند | الحد المقترح |
|---|---|
| الكتابة / الشات | `30,000` إلى `50,000` كلمة شهريًا |
| الصور الأساسية | `3` إلى `5` صور شهريًا كحد أعلى |
| المستندات | `10` إلى `20` مستندًا |
| الفريق | `0` |
| Social Media Agent | `0` |
| BlogPilot | `0` |
| Chatbot | `0` |
| Voice Call | `0` ثانية |
| Video | `0` |

### ترجمتها داخل شاشة credits

- النصوص منخفضة التكلفة: اسمح بها بحدود صغيرة وغير مفتوحة
- النماذج الممتازة جدًا أو الاستدلالية الثقيلة: `0`
- الصور premium: `0`
- الفيديو: `0`
- الصوت: `0`
- الوكلاء: `0`

---

## ما يجب أن يراه مستخدم Free داخل المنصة

### يظهر

- `Dashboard`
- `Documents`
- `AI Writer / Templates`
- `AI Chat`

### لا يظهر

- `Creative Suite`
- `AI Image Pro`
- `Social Media`
- `Social Media Agent`
- `BlogPilot`
- `Marketing Bot`
- `Chatbots / Channels`
- `AI Presentation`
- `AI Music Pro`
- `Voice Bots`
- `Video`

### لماذا؟

لأن `Free` في الوثائق الحالية ليس باقة "اكتشاف كل المنصة"، بل باقة:

- تجربة
- بناء ثقة
- دفع المستخدم إلى الترقية

---

## الرسالة التسويقية المقترحة لواجهة التسعير

### عنوان

`ابدأ مجانًا`

### وصف مختصر

`جرّب الشات والكتابة وصناعة المحتوى الأساسي داخل Boud AI بدون تكلفة، ثم قم بالترقية عندما تحتاج الصور المتقدمة أو السوشال أو الأتمتة.`

### نقاط العرض

- `شات وكتابة أساسيان`
- `قوالب محدودة`
- `استخدام شهري بسيط`
- `مناسب للتجربة قبل الترقية`

---

## قرار الجاهزية

### حالة Free بعد هذه الخلاصة

باقة `Free` أصبحت جاهزة من ناحية:

- الاسم
- الوصف
- التسعير
- القرار التجاري
- مفاتيح الصلاحيات
- حدود الوكلاء والـ chatbot
- قرار الإظهار للمستخدم

### ما بقي قبل الإطلاق العام

- إدخال القيم في لوحة الإدارة أو مزامنتها بقاعدة البيانات
- مراجعة شاشة الـ credits في Step 4 يدويًا
- إنهاء `Creator`
- إنهاء `Pro`
- فقط بعد ذلك: تحويل `hidden` من `true` إلى `false`

---

## الخلاصة التنفيذية

إذا أردنا نسخة `Free` نظيفة وآمنة تشغيليًا الآن، فهذه هي الصيغة المعتمدة:

- `Free = Chat + Writing + Minimal Templates`
- بدون فريق
- بدون سوشال
- بدون وكلاء
- بدون Chatbot
- بدون صوت
- بدون فيديو
- وتبقى **مخفية** حتى تكتمل الباقات المدفوعة
