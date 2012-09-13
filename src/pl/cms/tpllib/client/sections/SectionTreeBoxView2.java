package pl.cms.tpllib.client.sections;

import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.DialogBox;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.SimplePanel;

public class SectionTreeBoxView2 extends DialogBox {
	private Button btnCancel;

	private Button btnOk;
	
	private Label lblNewLabel;
	SimplePanel panel = new SimplePanel();
	AbsolutePanel absolutePanel = new AbsolutePanel();

	public SectionTreeBoxView2() {
		addStyleName("Y-system-DialogBox");
		setGlassEnabled(false);
		setAnimationEnabled(true);
		setHTML("Drzewo sekcji");
		
		
		
		
//		panel.setSize("100%", "100%");
		setWidget(panel);
		panel.setWidth("200px");
		
		panel.add(absolutePanel);
		
		
		SectionsTreeView sectionsTree = new SectionsTreeView();
		absolutePanel.add(sectionsTree);
		
		


		
		HTMLPanel buttonPanel = new HTMLPanel("");
		absolutePanel.add(buttonPanel);
		
		btnOk = new Button("Ok");
		buttonPanel.add(btnOk);
		
		btnOk.addClickHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {

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
