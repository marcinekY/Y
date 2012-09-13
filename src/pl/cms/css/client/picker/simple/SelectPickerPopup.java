package pl.cms.css.client.picker.simple;



public class SelectPickerPopup extends SelectPicker {
	
	private PickerPopup<SelectPicker> picker;

	public SelectPickerPopup() {
		this.picker = new PickerPopup<SelectPicker>(this);
		try {
			initWidget(picker);
		} catch (Exception e) {
			
		}
		
	}
	

	
	public void setPicker(PickerPopup<SelectPicker> picker) {
		this.picker = picker;
	}

	public PickerPopup<SelectPicker> getPicker() {
		return picker;
	}

	

}
