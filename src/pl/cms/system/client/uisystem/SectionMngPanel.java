package pl.cms.system.client.uisystem;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.DockLayoutPanel.Direction;

import com.google.gwt.user.client.ui.HasText;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.Tree;
import com.google.gwt.user.client.ui.Widget;
import com.google.gwt.user.client.ui.SplitLayoutPanel;

public class SectionMngPanel extends Composite  {

	private static SectionMngPanelUiBinder uiBinder = GWT
			.create(SectionMngPanelUiBinder.class);
	@UiField SplitLayoutPanel widgetPanel;

	interface SectionMngPanelUiBinder extends UiBinder<Widget, SectionMngPanel> {
	}
	
	public Direction treeViewDirection = Direction.WEST;
	private Tree treeView;

	public SectionMngPanel() {
		initWidget(uiBinder.createAndBindUi(this));
		treeView.add(new Label("Tree1"));
		treeView.add(new Label("Tree2"));
		treeView.add(new Label("Tree3"));
		treeView.add(new Label("Tree4"));
		
		switch (getTreeViewDirection()) {
	      case WEST:
	        widgetPanel.addWest(treeView, 30);
	        break;
	      case EAST:
	    	widgetPanel.addEast(treeView, 30);
	        break;
	      case NORTH:
	    	widgetPanel.addNorth(treeView, 30);
	        break;
	      case SOUTH:
	    	widgetPanel.addSouth(treeView, 30);
	        break;
	      default:
	        assert false : "Unexpected direction of section tree view";
	    }
	}

	public SectionMngPanel(String firstName) {
		initWidget(uiBinder.createAndBindUi(this));
//		button.setText(firstName);
	}

	public Direction getTreeViewDirection() {
		return treeViewDirection;
	}

	public void setTreeViewDirection(Direction treeViewDirection) {
		this.treeViewDirection = treeViewDirection;
	}

	

	

}
