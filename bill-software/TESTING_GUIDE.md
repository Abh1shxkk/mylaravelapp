# Purchase Transaction - Testing Guide

## Quick Testing Steps

### Test 1: Basic Flow - Single Row
1. Navigate to Purchase Transaction page
2. Select a supplier from dropdown
3. Click "Insert Orders" button
4. Select an order from modal
5. Items should populate in table
6. **Check**: Cursor should be on Row 1, first column
7. **Check**: Detailed Info shows basic data (Unit, Pack, Comp, NT Amt)
8. **Check**: Summary shows all 0.00

### Test 2: Complete First Row
1. Navigate through fields: Code → Name → Batch → Exp → Qty → F.Qty
2. Press Enter on F.Qty
3. **Check**: MRP modal opens
4. Fill MRP and Pur.Rate in modal
5. Click Save
6. **Check**: Modal closes, Pur.Rate field focused
7. Press Enter
8. **Check**: Dis.% field focused
9. Press Enter on Dis.%
10. **Check**: S.Rate field focused (in calculation section)
11. Fill S.Rate value
12. Press Enter
13. **Check**: GST amounts appear in calculation section
14. **Check**: Detailed Info updates with ALL calculated values:
    - Tax Amt should show value (not 0.00)
    - Cost should show value
    - Cost+GST should show value
    - Net Amt should show value
15. **Check**: Summary Section updates:
    - N.T AMT shows row amount
    - Tax shows tax amount
    - NET AMT shows net amount
    - INV.AMT shows net amount
16. **Check**: Cursor moves to Row 2 (blue highlight)

### Test 3: Multiple Rows
1. Complete Row 1 (as above)
2. **Check**: Summary shows Row 1 totals
3. Move to Row 2
4. **Check**: Detailed Info shows Row 2 basic data (not Row 1)
5. **Check**: Summary still shows Row 1 totals
6. Complete Row 2 (same process)
7. **Check**: Summary updates with CUMULATIVE totals:
    - N.T AMT = Row1 + Row2
    - Tax = Row1.tax + Row2.tax
    - NET AMT = Row1.net + Row2.net

### Test 4: Data Persistence
1. Complete Row 1 and Row 2
2. Click on Row 1 (or focus any cell in Row 1)
3. **Check**: Detailed Info shows Row 1 COMPLETE data (all calculated values)
4. **Check**: Summary still shows cumulative (Row 1 + Row 2)
5. Click on Row 2
6. **Check**: Detailed Info shows Row 2 complete data
7. **Check**: Summary unchanged (still cumulative)

### Test 5: Amount Recalculation
1. Complete Row 1
2. **Check**: Summary shows Row 1 totals
3. Change Qty in Row 1
4. **Check**: Amount recalculates automatically
5. **Check**: Detailed Info updates with new values
6. **Check**: Summary updates with new totals

### Test 6: Row Selection Navigation
1. Complete Row 1
2. Press Enter on S.Rate
3. **Check**: Cursor moves to Row 2 (full row selection - blue)
4. Press Arrow Down
5. **Check**: Cursor moves to Row 3 (blue highlight)
6. Press Arrow Up
7. **Check**: Cursor moves back to Row 2
8. Press Enter
9. **Check**: Cursor enters first cell of Row 2 (edit mode)

## Expected Values Example

### Row 1 Data:
- Item: ABAXIS 2.5 MG TAB.
- Qty: 10
- Pur.Rate: 128.58
- Dis.%: 0
- Amount: 1285.80
- CGST: 6%
- SGST: 6%

### Expected Calculations:
- CGST Amount: 77.15
- SGST Amount: 77.15
- Tax Amount: 154.30
- Net Amount: 1440.10
- Cost: 128.58
- Cost+GST: 144.01

### Summary After Row 1:
- N.T AMT: 1285.80
- Tax: 154.30
- NET AMT: 1440.10
- INV.AMT: 1440.10

## Common Issues to Check

### Issue 1: Detailed Info not updating
**Symptom**: Detailed Info shows 0.00 for calculated fields after S.Rate Enter
**Check**:
- Console for errors
- rowGstData[rowIndex].calculated should be true
- Item code should be valid

### Issue 2: Summary not accumulating
**Symptom**: Summary shows only last row, not cumulative
**Check**:
- updateSummarySection() is being called
- Loop through rowGstData is working
- Multiple rows have calculated: true

### Issue 3: Data not persisting
**Symptom**: Switching rows loses calculated data
**Check**:
- rowGstData object is storing data
- populateDetailedInfoSection() checks rowGstData[rowIndex]
- Row index is correct

### Issue 4: Cursor not moving to next row
**Symptom**: Enter on S.Rate doesn't move to next row
**Check**:
- S.Rate Enter key listener is attached
- selectRow() function is being called
- isRowSelected flag is set to true

## Console Debug Commands

Open browser console and run:

```javascript
// Check stored row data
console.log(rowGstData);

// Check current active row
console.log('Current Active Row:', currentActiveRow);

// Check if row is selected
console.log('Is Row Selected:', isRowSelected);

// Check specific row data
console.log('Row 0 Data:', rowGstData[0]);

// Manually trigger summary update
updateSummarySection();

// Manually populate detailed info for row 0
const rows = document.querySelectorAll('#itemsTableBody tr');
const itemCode = rows[0].querySelector('input[name*="[code]"]').value;
fetchItemDetailsForCalculation(itemCode, 0);
```

## Success Criteria

✅ **Detailed Info Section**
- Shows basic data (Unit, Pack, Comp, NT Amt) when cursor on incomplete row
- Shows ALL calculated data when cursor on completed row
- Updates immediately after S.Rate Enter
- Persists when switching between rows

✅ **Summary Section**
- Shows 0.00 initially
- Updates after first row complete
- Accumulates correctly for multiple rows
- Recalculates when row data changes

✅ **Navigation**
- Enter on Dis.% moves to S.Rate
- Enter on S.Rate calculates and moves to next row
- Arrow keys work in row selection mode
- Clicking row shows its data

✅ **Calculations**
- Amount = Qty × Pur.Rate - Discount
- Tax = CGST + SGST + CESS
- Net = Amount + Tax
- Cost = Amount / Qty
- Cost+GST = Net / Qty

✅ **Data Persistence**
- Row data saved in rowGstData
- Retrievable when switching rows
- Recalculates when values change

## Performance Check

- [ ] No lag when switching between rows
- [ ] Calculations happen instantly
- [ ] Summary updates smoothly
- [ ] No console errors
- [ ] Memory usage stable (check rowGstData size)

## Browser Compatibility

Test in:
- [ ] Chrome/Edge (Chromium)
- [ ] Firefox
- [ ] Safari (if available)

## Final Verification

Complete a full purchase transaction:
1. Select supplier
2. Load orders
3. Complete 5 rows
4. Verify all calculations correct
5. Verify summary shows cumulative of all 5 rows
6. Switch between rows - verify data persists
7. Change Qty in Row 2 - verify recalculation
8. Save transaction
9. Verify data saved to database

---

**Status**: ✅ Implementation Complete
**Last Updated**: 2025-11-03
**Version**: 1.0
