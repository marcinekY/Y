package pl.cms.tpllib.client.sections;

import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.DialogBox;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.HTML;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.Image;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.SimplePanel;

public class SectionsTreeBoxView extends DialogBox {
	private Button btnCancel;

	private Button btnOk;
	
	private Label lblNewLabel;
	
	SimplePanel panel = new SimplePanel();
	AbsolutePanel absolutePanel = new AbsolutePanel();
	
	public SectionsTreeBoxView() {
		addStyleName("Y-system-DialogBox");
		addStyleName("Y-system-SectionsControlTree");
		setGlassEnabled(false);
		setAnimationEnabled(true);
		setHTML("Drzewo sekcji");
		
		Image button = new Image("http://code.google.com/webtoolkit/logo-185x175.png"); 
		button.setPixelSize(20, 20);

	    button.addClickHandler(new ClickHandler(){ 
	        public void onClick(ClickEvent event) { 
	            hide();
	        }
	    }); 
	    button.setStyleName("dialog-close");

	    HorizontalPanel header = new HorizontalPanel();
	    header.add(new HTML("Example Tool"));
	    header.add(button);

	    setHTML(header.getElement().getInnerHTML());
		
		
//		panel.setSize("100%", "100%");
		setWidget(panel);
		panel.setWidth("200px");
		
		panel.add(absolutePanel);
		
		FlowPanel controllPanel = new FlowPanel();
		absolutePanel.add(controllPanel);
		
		Button btnAdd = new Button("+");
		controllPanel.add(btnAdd);
		
		Button btnDel = new Button("-");
		controllPanel.add(btnDel);
		
		Button btnE = new Button("e");
		controllPanel.add(btnE);
		
		
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
