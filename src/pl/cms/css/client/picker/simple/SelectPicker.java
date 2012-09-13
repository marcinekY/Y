package pl.cms.css.client.picker.simple;


import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.cell.client.TextCell;
import com.google.gwt.event.dom.client.ChangeEvent;
import com.google.gwt.event.dom.client.ChangeHandler;
import com.google.gwt.event.logical.shared.ValueChangeEvent;
import com.google.gwt.event.logical.shared.ValueChangeHandler;
import com.google.gwt.user.cellview.client.CellList;
import com.google.gwt.user.client.ui.ListBox;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.client.ui.ValuePicker;
import com.google.gwt.view.client.ListDataProvider;


public class SelectPicker extends SimplePickerImpl {

	private ValuePicker<String> valuePicker;
	private ItemsMng pickerValues = new ItemsMng();
	
	
	public SelectPicker() {
		init();
	}
	
	public void addItem(Value value,String text){
		pickerValues.addItem(value, text);
	}
	
	private void init(){
		setPicker();
		addHandlers();
		initWidget(valuePicker);
	}
	
	private void setPicker(){
		// Create a cell to render each value in the list.
	    TextCell textCell = new TextCell();

	    // Create a CellList that uses the cell.
	    CellList<String> cellList = new CellList<String>(textCell);

	    // Set the range to display. In this case, our visible range is smaller than
	    // the data set.
	    cellList.setVisibleRange(1, 3);

	    // Create a data provider.
	    ListDataProvider<String> dataProvider = new ListDataProvider<String>();
	    
	    // Connect the list to the data provider.
	    dataProvider.addDataDisplay(cellList);
	    
	    // Add the data to the data provider, which automatically pushes it to the
	    // widget. Our data provider will have seven values, but it will only push
	    // the four that are in range to the list.
	    

		
//		TextCell textCell = new TextCell();
//		CellList<String> typeList = new CellList<String>(textCell);
//		typeList.setRowData(0, pickerValues.getTexts());
		valuePicker = new ValuePicker<String>(pickerValues.getDilsplayCellList());
	}
	
	private void addHandlers(){
		valuePicker.addValueChangeHandler(new ValueChangeHandler<String>() {
			@Override
			public void onValueChange(ValueChangeEvent<String> event) {
//				sectionEntry.setType(event.getValue());
				Value v = pickerValues.getValue(event.getValue());
				setValue(v);
			}
		});
		
//		valuePicker.addDomHandler(new ChangeHandler() {
//			@Override
//			public void onChange(ChangeEvent event) {
//				String v = valuePicker.getValue();
////				Value v = new Value(value.getName(), getValue());
//				value.setValue(v);
//				if(listener!=null)
//					listener.setValue(value);
//			}
//		}, ChangeEvent.getType());
	}
	
	class ItemsMng {
		
		// Create a cell to render each value in the list.
	    TextCell textCell = new TextCell();

	    // Create a CellList that uses the cell.
	    CellList<String> cellList = new CellList<String>(textCell);
	    // Create a data provider.
	    ListDataProvider<String> dataProvider = new ListDataProvider<String>();
	    // Add the data to the data provider, which automatically pushes it to the
	    // widget. Our data provider will have seven values, but it will only push
	    // the four that are in range to the list.
	    List<String> texts = dataProvider.getList();
	    
//	    public List<Uzytkownik> pobierzOsobyZapisane() {
//	        System.out.println(\"Pobieranie listy osob zapisanych do newslettera\");
//	        ArrayList uzytkownicy = new ArrayList();
//	        uzytkownicy.add(new Uzytkownik(\"Jan\", \"Kowalski\", \"jan@kowalski.pl\"));
//	        uzytkownicy.add(new Uzytkownik(\"Anna\", \"Kowalska\", \"anna@kowalska.pl\"));
//	        return uzytkownicy;
//	      }
	    
	    
		
		private ArrayList<PickerItem> items = new ArrayList<PickerItem>();
		

		public ItemsMng(){
			// Set the range to display. In this case, our visible range is smaller than
		    // the data set.
//		    cellList.setVisibleRange(1, 1);
		    
		}
		public void refreshTextsList(){
			List<String> l = Arrays.asList();
			texts.clear();
			if(items!=null){
				for (int i = 0; i < items.size(); i++) {
					texts.add(items.get(i).getText());
				}
			}
		}
		public CellList<String> getDilsplayCellList(){
			dataProvider.addDataDisplay(cellList);
			return cellList;
		}
		public void addItem(Value value,String text){
			addItem(new PickerItem(value, text));
		}
		public void addItem(PickerItem item){
			if(item!=null){
				texts.add(item.getText());
				items.add(item);
			}
		}
		public Value getValue(String text){
			return getItem(text).getValue();
		}
		public PickerItem getItem(String text){
			if(items!=null){
				for (int i = 0; i < items.size(); i++) {
					if(items.get(i).getText().equals(text)){
						return items.get(i);
					}
				}
			}
			return null;
		}
	}
	
	private class PickerItem {
		private Value value;
		private String text;
		/**
		 * @param value
		 * @param text
		 */
		public PickerItem(Value value, String text) {
			super();
			this.value = value;
			this.text = text;
		}
		public Value getValue() {
			return value;
		}
		public void setValue(Value value) {
			this.value = value;
		}
		public String getText() {
			return text;
		}
		public void setText(String text) {
			this.text = text;
		}
	}
	
}
