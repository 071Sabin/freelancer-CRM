TABLE: INVOICES

id (uuid or bigint)
user_id (owner / tenant)
client_id
project_id

invoice_number
status

issue_date
due_date

currency

subtotal
tax_total
discount_total
total

notes
terms

sent_at
paid_at

created_at
updated_at

Why this table exists?
Single source of truth
Stores final monetary values
Read-heavy table (dashboards)

=============================================================================
*****************************************************************************
=============================================================================
TABLE: invoice_items
// this table is to create different items in invooice like backend, ui fix and how much each of these cost then total of those.
// trying to keep all these in single table will corrupt the data.

id
invoice_id

description
quantity
unit_price
line_total

created_at
updated_at

Why?
Line-level audit
Supports hours, products, retainers
Easy PDF rendering

=============================================================================
*****************************************************************************
=============================================================================
TABLE: invoice_taxes
// Stores the taxes applied to an invoice, including the tax name, rate, and amount.
// invoice_taxes stores WHAT ACTUALLY HAPPENED on a specific invoice.

id
invoice_id

name
rate
amount

created_at
updated_at

Why?
Multiple tax lines per invoice
Works for GST, VAT, Sales Tax
No country logic baked in

=============================================================================
*****************************************************************************
=============================================================================
TABLE: invoice_settings

id
user_id

prefix
next_number

default_currency
default_tax_rate
default_terms
default_notes

logo_path

created_at
updated_at

Why?
No hardcoding
Per-user customization
Envato-safe flexibility

=============================================================================
*****************************************************************************
=============================================================================

TABLE: invoice_activity_logs

id
invoice_id
user_id

action
meta (json)

created_at

Why?
Auditing
Debugging
Trust in financial data

=============================================================================
*****************************************************************************
=============================================================================

