# Purchase Transaction Flow Diagram

## Visual Flow Representation

```
┌─────────────────────────────────────────────────────────────────────┐
│                    PURCHASE TRANSACTION FLOW                         │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│ STEP 1: SELECT SUPPLIER & LOAD ORDERS                                │
└─────────────────────────────────────────────────────────────────────┘
    │
    ├─► Select Supplier from dropdown
    │
    ├─► Click "Insert Orders" button
    │
    └─► Modal opens with pending orders
         │
         └─► Select Order → Items populate in table


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 2: CURSOR ON ROW 1 (Incomplete)                                 │
└─────────────────────────────────────────────────────────────────────┘

    ITEMS TABLE (Row 1):
    ┌──────┬──────────┬───────┬──────┬─────┬──────┬─────────┬──────┬─────┬────────┐
    │ Code │   Name   │ Batch │ Exp. │ Qty │ F.Qty│ Pur.Rate│ Dis% │ MRP │ Amount │
    ├──────┼──────────┼───────┼──────┼─────┼──────┼─────────┼──────┼─────┼────────┤
    │ 1234 │ ABAXIS   │ B1897 │11/28 │ 10  │  0   │ 128.58  │  0   │ 200 │1285.80 │
    └──────┴──────────┴───────┴──────┴─────┴──────┴─────────┴──────┴─────┴────────┘
                                          ▲
                                          │ Cursor here
    
    DETAILED INFO SECTION (Shows BASIC data only):
    ┌────────────────────────────────────────────────────────────────┐
    │ Unit: 1          │ N.T Amt.: 1285.80  │ Tax Amt.: 0.00      │
    │ Pack: 1*10       │ Scm.Amt.: 0.00     │ Cost: 0.00          │
    │ Cl.Qty: 10       │ Dis.Amt.: 0.00     │ Cost+GST: 0.00      │
    │ Comp: INTAS      │ Gross Amt.: 1285.80│ Net Amt.: 0.00      │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Only basic fields populated
    
    SUMMARY SECTION (No complete rows yet):
    ┌────────────────────────────────────────────────────────────────┐
    │ N.T AMT: 0.00    │ SC: 0.00      │ SCM.: 0.00   │ DIS.: 0.00  │
    │ NET AMT.: 0.00   │ Scm.%: 0.00   │ TCS: 0.00    │ Tax: 0.00   │
    │ INV.AMT.: 0.00   │               │              │             │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ All zeros (no completed rows)


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 3: FILL ROW 1 DATA                                              │
└─────────────────────────────────────────────────────────────────────┘

    Navigation Flow:
    Code → Name → Batch → Exp → Qty → F.Qty
                                        │
                                        ├─► Enter pressed
                                        │
                                        └─► MRP Modal Opens
                                             │
                                             ├─► Fill MRP, Pur.Rate
                                             │
                                             └─► Save → Modal closes
                                                  │
                                                  └─► Pur.Rate field focused
                                                       │
                                                       └─► Enter → Dis.% focused
                                                            │
                                                            └─► Enter → S.Rate focused
                                                                 │
                                                                 └─► Fill S.Rate
                                                                      │
                                                                      └─► Enter pressed
                                                                           │
                                                                           ▼


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 4: S.RATE ENTER PRESSED - ROW 1 COMPLETE                        │
└─────────────────────────────────────────────────────────────────────┘

    ┌──────────────────────────────────────────────────────────────┐
    │ 1. Calculate GST amounts                                      │
    │    - CGST = Amount × 6% = 73.67                              │
    │    - SGST = Amount × 6% = 73.67                              │
    │    - CESS = Amount × 0% = 0.00                               │
    │    - Tax = 147.34                                             │
    │    - Net = 1285.80 + 147.34 = 1433.14                        │
    │    - Cost = 1285.80 / 10 = 128.58                            │
    │    - Cost+GST = 1433.14 / 10 = 143.31                        │
    └──────────────────────────────────────────────────────────────┘
                           │
                           ▼
    ┌──────────────────────────────────────────────────────────────┐
    │ 2. Save to rowGstData[0]                                      │
    │    rowGstData[0] = {                                          │
    │        calculated: true,                                      │
    │        amount: "1285.80",                                     │
    │        cgstAmount: "73.67",                                   │
    │        sgstAmount: "73.67",                                   │
    │        cessAmount: "0.00",                                    │
    │        taxAmount: "147.34",                                   │
    │        netAmount: "1433.14",                                  │
    │        cost: "128.58",                                        │
    │        costGst: "143.31"                                      │
    │    }                                                          │
    └──────────────────────────────────────────────────────────────┘
                           │
                           ▼
    ┌──────────────────────────────────────────────────────────────┐
    │ 3. Update DETAILED INFO with calculated values                │
    └──────────────────────────────────────────────────────────────┘
    
    DETAILED INFO SECTION (Now shows ALL calculated data):
    ┌────────────────────────────────────────────────────────────────┐
    │ Unit: 1          │ N.T Amt.: 1285.80  │ Tax Amt.: 147.34    │
    │ Pack: 1*10       │ Scm.Amt.: 0.00     │ Cost: 128.58        │
    │ Cl.Qty: 10       │ Dis.Amt.: 0.00     │ Cost+GST: 143.31    │
    │ Comp: INTAS      │ Gross Amt.: 1285.80│ Net Amt.: 1433.14   │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ ALL fields now populated with calculated values
                           │
                           ▼
    ┌──────────────────────────────────────────────────────────────┐
    │ 4. Update SUMMARY SECTION                                     │
    └──────────────────────────────────────────────────────────────┘
    
    SUMMARY SECTION (Row 1 totals):
    ┌────────────────────────────────────────────────────────────────┐
    │ N.T AMT: 1285.80 │ SC: 0.00      │ SCM.: 0.00   │ DIS.: 0.00  │
    │ NET AMT.: 1433.14│ Scm.%: 0.00   │ TCS: 0.00    │ Tax: 147.34 │
    │ INV.AMT.: 1433.14│               │              │             │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Shows Row 1 totals
                           │
                           ▼
    ┌──────────────────────────────────────────────────────────────┐
    │ 5. Move to Row 2 (Full row selection - Blue highlight)       │
    └──────────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 5: CURSOR ON ROW 2 (Incomplete)                                 │
└─────────────────────────────────────────────────────────────────────┘

    ITEMS TABLE:
    ┌──────┬──────────┬───────┬──────┬─────┬──────┬─────────┬──────┬─────┬────────┐
    │ 1234 │ ABAXIS   │ B1897 │11/28 │ 10  │  0   │ 128.58  │  0   │ 200 │1285.80 │ ← Row 1 (Complete)
    ├──────┼──────────┼───────┼──────┼─────┼──────┼─────────┼──────┼─────┼────────┤
    │ 5678 │ ABAXIS-5 │ N2502 │05/28 │ 10  │  0   │ 147.70  │  0   │ 229 │1477.00 │ ← Row 2 (Current)
    └──────┴──────────┴───────┴──────┴─────┴──────┴─────────┴──────┴─────┴────────┘
                                          ▲
                                          │ Cursor moved here
    
    DETAILED INFO SECTION (Shows Row 2 BASIC data):
    ┌────────────────────────────────────────────────────────────────┐
    │ Unit: 1          │ N.T Amt.: 1477.00  │ Tax Amt.: 0.00      │
    │ Pack: 1*10       │ Scm.Amt.: 0.00     │ Cost: 0.00          │
    │ Cl.Qty: 10       │ Dis.Amt.: 0.00     │ Cost+GST: 0.00      │
    │ Comp: INTAS      │ Gross Amt.: 1477.00│ Net Amt.: 0.00      │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Row 2 basic data (not complete yet)
    
    SUMMARY SECTION (Still shows Row 1 totals):
    ┌────────────────────────────────────────────────────────────────┐
    │ N.T AMT: 1285.80 │ SC: 0.00      │ SCM.: 0.00   │ DIS.: 0.00  │
    │ NET AMT.: 1433.14│ Scm.%: 0.00   │ TCS: 0.00    │ Tax: 147.34 │
    │ INV.AMT.: 1433.14│               │              │             │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Row 1 data PERSISTED


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 6: COMPLETE ROW 2 (Same process as Row 1)                       │
└─────────────────────────────────────────────────────────────────────┘

    After S.Rate Enter on Row 2:
    
    SUMMARY SECTION (CUMULATIVE - Row 1 + Row 2):
    ┌────────────────────────────────────────────────────────────────┐
    │ N.T AMT: 2762.80 │ SC: 0.00      │ SCM.: 0.00   │ DIS.: 0.00  │
    │                  │               │              │             │
    │ NET AMT.: 3080.38│ Scm.%: 0.00   │ TCS: 0.00    │ Tax: 317.58 │
    │                  │               │              │             │
    │ INV.AMT.: 3080.38│               │              │             │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │
                    │ N.T AMT = 1285.80 + 1477.00 = 2762.80
                    │ Tax = 147.34 + 170.24 = 317.58
                    │ NET AMT = 1433.14 + 1647.24 = 3080.38


┌─────────────────────────────────────────────────────────────────────┐
│ STEP 7: SWITCH BACK TO ROW 1 (Click on it)                           │
└─────────────────────────────────────────────────────────────────────┘

    DETAILED INFO SECTION (Shows Row 1 COMPLETE data):
    ┌────────────────────────────────────────────────────────────────┐
    │ Unit: 1          │ N.T Amt.: 1285.80  │ Tax Amt.: 147.34    │
    │ Pack: 1*10       │ Scm.Amt.: 0.00     │ Cost: 128.58        │
    │ Cl.Qty: 10       │ Dis.Amt.: 0.00     │ Cost+GST: 143.31    │
    │ Comp: INTAS      │ Gross Amt.: 1285.80│ Net Amt.: 1433.14   │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Row 1 complete data retrieved from rowGstData[0]
    
    SUMMARY SECTION (Still shows cumulative):
    ┌────────────────────────────────────────────────────────────────┐
    │ N.T AMT: 2762.80 │ SC: 0.00      │ SCM.: 0.00   │ DIS.: 0.00  │
    │ NET AMT.: 3080.38│ Scm.%: 0.00   │ TCS: 0.00    │ Tax: 317.58 │
    │ INV.AMT.: 3080.38│               │              │             │
    └────────────────────────────────────────────────────────────────┘
                    ▲
                    │ Cumulative totals maintained


┌─────────────────────────────────────────────────────────────────────┐
│ DATA PERSISTENCE DIAGRAM                                              │
└─────────────────────────────────────────────────────────────────────┘

    rowGstData Object:
    ┌─────────────────────────────────────────────────────────────┐
    │ rowGstData = {                                               │
    │     0: {                                                     │
    │         calculated: true,                                    │
    │         amount: "1285.80",                                   │
    │         taxAmount: "147.34",                                 │
    │         netAmount: "1433.14",                                │
    │         cost: "128.58",                                      │
    │         costGst: "143.31",                                   │
    │         ...                                                  │
    │     },                                                       │
    │     1: {                                                     │
    │         calculated: true,                                    │
    │         amount: "1477.00",                                   │
    │         taxAmount: "170.24",                                 │
    │         netAmount: "1647.24",                                │
    │         cost: "147.70",                                      │
    │         costGst: "164.72",                                   │
    │         ...                                                  │
    │     },                                                       │
    │     2: { calculated: false },  // Not complete yet          │
    │     ...                                                      │
    │ }                                                            │
    └─────────────────────────────────────────────────────────────┘
                           │
                           ├─► Used by: populateDetailedInfoSection()
                           │
                           └─► Used by: updateSummarySection()


┌─────────────────────────────────────────────────────────────────────┐
│ CALCULATION FLOW                                                      │
└─────────────────────────────────────────────────────────────────────┘

    User fills row data
           │
           ▼
    Qty × Pur.Rate - Discount = Amount
           │
           ▼
    User presses Enter on Dis.%
           │
           ▼
    Cursor moves to S.Rate
           │
           ▼
    User fills S.Rate & presses Enter
           │
           ▼
    ┌─────────────────────────────────────────────┐
    │ calculateAndSaveGstForRow(rowIndex)         │
    │                                              │
    │ 1. Fetch item GST percentages                │
    │ 2. Calculate:                                │
    │    - CGST Amount                             │
    │    - SGST Amount                             │
    │    - CESS Amount                             │
    │    - Tax Amount (sum of above)               │
    │    - Net Amount (Amount + Tax)               │
    │    - Cost (Amount / Qty)                     │
    │    - Cost+GST (Net / Qty)                    │
    │ 3. Save to rowGstData[rowIndex]              │
    │ 4. Call updateDetailedInfoWithCalculatedData()│
    │ 5. Call updateSummarySection()               │
    └─────────────────────────────────────────────┘
           │
           ▼
    Move to next row (full row selection)


┌─────────────────────────────────────────────────────────────────────┐
│ KEY FEATURES                                                          │
└─────────────────────────────────────────────────────────────────────┘

✅ Dynamic data population based on cursor position
✅ Shows basic data for incomplete rows
✅ Shows complete data for completed rows
✅ Cumulative summary calculation
✅ Data persistence when switching between rows
✅ Automatic recalculation when row data changes
✅ Professional UX with smooth transitions
✅ Matches exact behavior from main software images
```
