package pl.cms.tpllib.client.sections;

import java.util.Arrays;
import java.util.List;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;

import com.google.gwt.cell.client.TextCell;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.logical.shared.ValueChangeEvent;
import com.google.gwt.event.logical.shared.ValueChangeHandler;
import com.google.gwt.user.cellview.client.CellList;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.DialogBox;
import com.google.gwt.user.client.ui.FormPanel;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.SimplePanel;
import com.google.gwt.user.client.ui.ValuePicker;

public class SectionAddView extends DialogBox {
	private Button btnCancel;
	
	private static final List<String> types = Arrays.asList("HORIZONTAL", "VERTICAL",
		      "SIMPLE","FLOW");
	
	private SectionDataEntry sectionEntry;
	private SectionDataEntry parentSectionEntry;
	private Button btnOk;
	private ValuePicker<String> valuePicker;
	private Label lblNewLabel;
	private AbsolutePanel absolutePanel;
	private FormPanel formPanel;

	public SectionAddView() {
		setGlassEnabled(true);
		setHTML("Dodaj/Edytuj sekcj\u0119");
//		setSize("600px", "400px");

		addStyleName("Y-system-DialogBox");
		
		
		SimplePanel panel = new SimplePanel();
//		panel.setSize("100%", "100%");
		setWidget(panel);
		panel.setWidth("250px");
		
		formPanel = new FormPanel();
		panel.setWidget(formPanel);
		formPanel.setSize("100%", "100%");
		
		absolutePanel = new AbsolutePanel();
		formPanel.setWidget(absolutePanel);
		absolutePanel.setSize("100%", "100%");
		
		lblNewLabel = new Label("Wybierz typ:");
		absolutePanel.add(lblNewLabel);
		
		TextCell textCell = new TextCell();
		CellList<String> typeList = new CellList<String>(textCell);
		typeList.setRowData(0, types);
		
		valuePicker = new ValuePicker<String>(typeList);
		valuePicker.addValueChangeHandler(new ValueChangeHandler<String>() {
			public void onValueChange(ValueChangeEvent<String> event) {
				sectionEntry.setType(event.getValue());
			}
		});
		absolutePanel.add(valuePicker);
		
		HTMLPanel buttonPanel = new HTMLPanel("");
		absolutePanel.add(buttonPanel);
		
		btnOk = new Button("Ok");
		buttonPanel.add(btnOk);
		
		btnOk.addClickHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				sectionEntry.setType(valuePicker.getValue());
				hide();
			}
		});
		
		btnCancel = new Button("Cancel");
		buttonPanel.add(btnCancel);
		btnCancel.addClickHandler(new ClickHandler() {
			public void onClick(ClickEvent event) {
				
				hide();
			}
		});
		
		center();
	}
	
	public void refreshDataPanel(){
		if(parentSectionEntry!=null){
			sectionEntry.setParentId(parentSectionEntry.getId());
		}
	}

	public SectionDataEntry getSectionEntry() {
		return sectionEntry;
	}

	public void setSectionEntry(SectionDataEntry sectionEntry) {
		this.sectionEntry = sectionEntry;
	}

	public SectionDataEntry getParentSectionEntry() {
		return parentSectionEntry;
	}

	public void setParentSectionEntry(SectionDataEntry parentSectionEntry) {
		this.parentSectionEntry = parentSectionEntry;
	}

	public Button getBtnCancel() {
		return btnCancel;
	}

	public void setBtnCancel(Button btnCancel) {
		this.btnCancel = btnCancel;
	}

	public Button getBtnOk() {
		return btnOk;
	}

	public void setBtnOk(Button btnOk) {
		this.btnOk = btnOk;
	}

	
	
	
}
