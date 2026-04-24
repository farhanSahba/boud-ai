# Developer Docs Notes - 2026-04-24

## Purpose
- Capture only the useful parts from the official MagicProject documentation that help the current Boud AI implementation.
- Keep this as a practical reference, not a full documentation mirror.

## Source
- Official docs homepage: `https://docs.magicproject.ai/`

## Most Relevant Pages
- `Creating Pricing Plans`
- `AI Model Selector for AI Chat`
- `Which AI Tool Uses Which API?`
- `Social Media Suite Setup`
- `Marketing Bot`
- `Social Media Suite vs. AI Social Media Extension`

## What We Learned

### 1. Pricing plans are a core product structure
- The original product expects plans to be configured from admin under finance/pricing plans.
- Subscription plans are not just name + price.
- They include:
  - plan details
  - payment readiness
  - feature access
  - template access
  - usage limits

### 2. Payment gateways matter to final launch readiness
- The documentation explicitly notes that plan creation is tied to payment gateway setup.
- For our project, this means the plans can exist technically before launch, but they are not commercially complete until gateway/products mapping is checked.

### 3. AI model availability should be plan-aware
- The model selector documentation reinforces that AI model exposure is part of plan design.
- This supports our current direction:
  - not every plan should get every model
  - premium models should be restricted to higher tiers

### 4. Not all AI tools are equal in cost
- The page `Which AI Tool Uses Which API?` is important because it confirms that tools are backed by different providers and therefore different cost profiles.
- This supports our pricing logic:
  - cheap text features can be wider
  - expensive image/video/voice features should be limited or moved to higher plans / add-ons

### 5. Social media features are layered
- The docs distinguish between broader social-media capabilities and narrower extensions.
- This validates our earlier product architecture:
  - lighter social content features can sit in lower plans
  - advanced social agents / automation should stay in higher plans

### 6. Marketing Bot is a plan-worthy premium feature
- The documentation treats Marketing Bot as a meaningful standalone capability.
- This supports keeping it away from Free and likely away from Creator unless there is a strong business reason.

## Practical Impact On Our Project

### Good decisions already aligned with docs
- Creating `Free / Creator / Pro / Agency`
- Gating `BlogPilot`, `SocialMediaAgent`, and `Marketing Bot` by plan
- Keeping plans hidden during internal setup
- Thinking in terms of visibility + direct-access blocking

### Things still needed before launch
- complete plan descriptions
- final template access decisions
- final model-access decisions
- final usage-limit decisions
- final payment/gateway readiness review

## Important Warning
- The official docs describe the original MagicAI product behavior.
- Our Boud AI build has already diverged in some areas:
  - local marketplace behavior
  - installer/license handling
  - custom entitlements
- So the docs are a strong reference, but not the single source of truth for our modified build.

## Best Use Of This Reference
- Use it to validate product design decisions.
- Use local code and live behavior to validate implementation details.
- If docs and code differ, trust the current project behavior after verifying why.

## Recommended Next Step
- Continue plan completion using:
  1. local code behavior
  2. live server behavior
  3. this documentation reference as guidance
