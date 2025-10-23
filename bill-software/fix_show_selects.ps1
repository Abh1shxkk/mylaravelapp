$showFile = "c:\xampp\htdocs\bill-software\resources\views\admin\customers\show.blade.php"
$content = Get-Content $showFile -Raw

# Replace all select dropdowns with display paragraphs
# Pattern: Find select with name and replace entire select block with paragraph

# State Code GST
$content = $content -replace '<select class="form-select" name="state_code_gst">.*?</select>', '<p class="form-control-plaintext">{{ $customer->state_code_gst ?? ''-'' }}</p>', 'Singleline'

# Registration Status
$content = $content -replace '<select class="form-select" name="registration_status">.*?</select>', '<p class="form-control-plaintext">{{ $customer->registration_status ?? ''-'' }}</p>', 'Singleline'

# Business Type
$content = $content -replace '<select class="form-select" name="business_type">.*?</select>', '<p class="form-control-plaintext">{{ $customer->business_type ?? ''-'' }}</p>', 'Singleline'

# Sale Rate Type
$content = $content -replace '<select class="form-select" name="sale_rate_type">.*?</select>', '<p class="form-control-plaintext">{{ $customer->sale_rate_type ?? ''-'' }}</p>', 'Singleline'

# Expiry On
$content = $content -replace '<select class="form-select" name="expiry_on">.*?</select>', '<p class="form-control-plaintext">{{ $customer->expiry_on ?? ''-'' }}</p>', 'Singleline'

# Expiry RN On
$content = $content -replace '<select class="form-select" name="expiry_rn_on">.*?</select>', '<p class="form-control-plaintext">{{ $customer->expiry_rn_on ?? ''-'' }}</p>', 'Singleline'

# Dis On Excise
$content = $content -replace '<select class="form-select" name="dis_on_excise">.*?</select>', '<p class="form-control-plaintext">{{ $customer->dis_on_excise ?? ''-'' }}</p>', 'Singleline'

# Sale Pur Status
$content = $content -replace '<select class="form-select" name="sale_pur_status">.*?</select>', '<p class="form-control-plaintext">{{ $customer->sale_pur_status ?? ''-'' }}</p>', 'Singleline'

# Scheme Type
$content = $content -replace '<select class="form-select" name="scm_type">.*?</select>', '<p class="form-control-plaintext">{{ $customer->scm_type ?? ''-'' }}</p>', 'Singleline'

# Net Rate
$content = $content -replace '<select class="form-select" name="net_rate">.*?</select>', '<p class="form-control-plaintext">{{ $customer->net_rate ?? ''-'' }}</p>', 'Singleline'

# SR Replacement
$content = $content -replace '<select class="form-select" name="sr_replacement">.*?</select>', '<p class="form-control-plaintext">{{ $customer->sr_replacement ?? ''-'' }}</p>', 'Singleline'

# Cash Sale
$content = $content -replace '<select class="form-select" name="cash_sale">.*?</select>', '<p class="form-control-plaintext">{{ $customer->cash_sale ?? ''-'' }}</p>', 'Singleline'

# TDS
$content = $content -replace '<select class="form-select" name="tds">.*?</select>', '<p class="form-control-plaintext">{{ $customer->tds ?? ''-'' }}</p>', 'Singleline'

# Add Charges with GST
$content = $content -replace '<select class="form-select" name="add_charges_with_gst">.*?</select>', '<p class="form-control-plaintext">{{ $customer->add_charges_with_gst ?? ''-'' }}</p>', 'Singleline'

# TCS Applicable
$content = $content -replace '<select class="form-select" name="tcs_applicable">.*?</select>', '<p class="form-control-plaintext">{{ $customer->tcs_applicable ?? ''-'' }}</p>', 'Singleline'

# BE Incl
$content = $content -replace '<select class="form-select" name="be_incl">.*?</select>', '<p class="form-control-plaintext">{{ $customer->be_incl ?? ''-'' }}</p>', 'Singleline'

# Brk Expiry Msg in Sale
$content = $content -replace '<select class="form-select" name="brk_expiry_msg_in_sale">.*?</select>', '<p class="form-control-plaintext">{{ $customer->brk_expiry_msg_in_sale ?? ''-'' }}</p>', 'Singleline'

# Expiry Repl Credit
$content = $content -replace '<select class="form-select" name="expiry_repl_credit">.*?</select>', '<p class="form-control-plaintext">{{ $customer->expiry_repl_credit ?? ''-'' }}</p>', 'Singleline'

# Tax on Br Expiry
$content = $content -replace '<select class="form-select" name="tax_on_br_expiry">.*?</select>', '<p class="form-control-plaintext">{{ $customer->tax_on_br_expiry ?? ''-'' }}</p>', 'Singleline'

# Dis After Scheme
$content = $content -replace '<select class="form-select" name="dis_after_scheme">.*?</select>', '<p class="form-control-plaintext">{{ $customer->dis_after_scheme ?? ''-'' }}</p>', 'Singleline'

# Max Limit On
$content = $content -replace '<select class="form-select" name="max_limit_on">.*?</select>', '<p class="form-control-plaintext">{{ $customer->max_limit_on ?? ''-'' }}</p>', 'Singleline'

# Follow Conditions Strictly
$content = $content -replace '<select class="form-select" name="follow_conditions_strictly">.*?</select>', '<p class="form-control-plaintext">{{ $customer->follow_conditions_strictly ?? ''-'' }}</p>', 'Singleline'

# Open Lock Once
$content = $content -replace '<select class="form-select" name="open_lock_once">.*?</select>', '<p class="form-control-plaintext">{{ $customer->open_lock_once ?? ''-'' }}</p>', 'Singleline'

# Expiry Lock Type
$content = $content -replace '<select class="form-select" name="expiry_lock_type">.*?</select>', '<p class="form-control-plaintext">{{ $customer->expiry_lock_type ?? ''-'' }}</p>', 'Singleline'

# Order Required
$content = $content -replace '<select class="form-select" name="order_required">.*?</select>', '<p class="form-control-plaintext">{{ $customer->order_required ?? ''-'' }}</p>', 'Singleline'

# Invoice Export
$content = $content -replace '<select class="form-select" name="invoice_export">.*?</select>', '<p class="form-control-plaintext">{{ $customer->invoice_export ?? ''-'' }}</p>', 'Singleline'

# Local Central
$content = $content -replace '<select class="form-select" name="local_central">.*?</select>', '<p class="form-control-plaintext">{{ $customer->local_central ?? ''-'' }}</p>', 'Singleline'

# Balance Type
$content = $content -replace '<select class="form-select" name="balance_type">.*?</select>', '<p class="form-control-plaintext">{{ $customer->balance_type ?? ''-'' }}</p>', 'Singleline'

# Remove any remaining button tags
$content = $content -replace '<button[^>]*>.*?</button>', '', 'Singleline'

# Save
Set-Content -Path $showFile -Value $content -NoNewline

Write-Host "All select fields converted to display paragraphs!" -ForegroundColor Green
