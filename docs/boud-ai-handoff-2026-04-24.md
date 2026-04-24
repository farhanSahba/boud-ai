# Boud AI Handoff - 2026-04-24

## Purpose
- Preserve the current state so work can continue in a new thread without losing context.

## Repository
- Local project: `C:\Users\farha\Desktop\My projects\backup003\project_backup`
- GitHub repo: `boud-ai`

## Strategy Docs Already Created
- `docs/market-pricing-analysis-2026-04-24.html`
- `docs/boud-ai-feasibility-study-2026-04-24.html`
- `docs/boud-ai-plan-architecture-2026-04-24.html`
- `docs/boud-ai-package-matrix-2026-04-24.html`
- `docs/boud-ai-entitlement-execution-2026-04-24.html`

## Server State Summary
- Project deployed and working on `bued-ai.com`
- Local installer flow was enabled and licensing flow was bypassed for this build
- Marketplace was converted to local-extension behavior
- Missing themes were restored
- `SocialMediaAgent` was restored from the full backup and its migrations were applied
- RTL sidedrawer issue for Arabic notifications was fixed
- Plans were created on the live server:
  - `Free`
  - `Creator`
  - `Pro`
  - `Agency`

## Plans Work Already Done
- Plan capability keys were extended in menu/entitlement logic for:
  - `BlogPilot`
  - `SocialMediaAgent`
  - `Marketing Bot`
- Route-level protection was added so direct URLs can be blocked by plan
- Sidebar visibility logic was aligned with plan capability keys

## Important Current Reality
- The plans exist in admin
- User pricing page currently hides plans if `hidden = 1`
- Earlier server-side plan creation intentionally used `hidden = 1`
- Therefore admin can see plans while normal users do not see them yet

## Important Architectural Decision
- Add-ons/extensions should stay in the project
- Visibility and access should be controlled by subscription plans
- Current preferred direction:
  - keep modules installed
  - hide or show them by plan
  - also block direct access by plan

## Known Outstanding Work On Plans
- The plans are not launch-ready yet
- They are initial technical skeletons, not fully completed commercial plans
- Still needs review/completion:
  - descriptions
  - marketing copy
  - default AI model
  - template access
  - usage limits
  - chatbot options
  - team settings
  - payment/display readiness
  - whether plans should remain hidden or go live

## Recommended Next Working Order
1. Finalize `Free`
2. Finalize `Creator`
3. Finalize `Pro`
4. Finalize `Agency`

## Notes For Next Thread
- Do not reopen old topics like installer/theme/translation fixes unless the user asks
- Continue directly from subscription-plan completion
- First check whether plans should remain hidden or be shown to users
- Then complete the plan fields step-by-step starting with `Free`
