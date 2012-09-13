package pl.cms.tpllib.client.sections;

import java.util.ArrayList;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import pl.cms.tpllib.client.sections.events.AddSectionEvent;
import pl.cms.tpllib.client.sections.events.AddSectionEventHandler;
import pl.cms.tpllib.client.sections.events.ChangeSectionEvent;
import pl.cms.tpllib.client.sections.events.ChangeSectionEventHandler;
import pl.cms.tpllib.client.sections.events.SelectSectionEvent;
import pl.cms.tpllib.client.sections.util.SectionPanel;
import pl.cms.tpllib.client.sections.util.SectionTreeItemPanel;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.logical.shared.SelectionEvent;
import com.google.gwt.event.logical.shared.SelectionHandler;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HasText;
import com.google.gwt.user.client.ui.Tree;
import com.google.gwt.user.client.ui.TreeItem;
import com.google.gwt.user.client.ui.Widget;
import com.google.gwt.user.client.ui.HTMLPanel;

public class SectionsTreeView extends Composite {

	private static SectionsTreePanelUiBinder uiBinder = GWT
			.create(SectionsTreePanelUiBinder.class);
	@UiField HTMLPanel panel;
	@UiField Tree treePanel;


	interface SectionsTreePanelUiBinder extends
			UiBinder<Widget, SectionsTreeView> {
	}

	private EventBus eventBus;
	private ArrayList<SectionTreeItemPanel> panels = new ArrayList<SectionTreeItemPanel>();

	public SectionsTreeView() {
		initWidget(uiBinder.createAndBindUi(this));
		panel.setSize("100%", "500px");
		treePanel.addSelectionHandler(new SelectionHandler<TreeItem>() {
			@Override
			public void onSelection(SelectionEvent<TreeItem> event) {
				eventBus.fireEvent(new SelectSectionEvent(event.getSelectedItem().getElement().getAttribute("sId")));
			}
		});
	}
	
	private void addHandlers() {
//		eventBus.addHandler(AddSectionEvent.TYPE, new AddSectionEventHandler() {
//			
//			@Override
//			public void onSectionAdd(AddSectionEvent sectionAddEvent) {
//				addSection(sectionAddEvent.getSectionData());
//			}
//		});
	}
	
	public SectionDataEntry getSelected() {
		if(panels!=null){
			for (int i = 0; i < panels.size(); i++) {
				if(panels.get(i).isSelected()) return panels.get(i).getData();
			}
		}
		return null;
	}
	
	public void addSection(SectionDataEntry se){
		SectionTreeItemPanel sp = new SectionTreeItemPanel(se);
		
		SectionTreeItemPanel root = getSectionTreeItemPanel(se.getParentId());
		if(root==null){
			treePanel.addItem(sp);
		} else {
			root.addSection(sp);
		}
		panels.add(sp);
	}
	
	private SectionTreeItemPanel getSectionTreeItemPanel(String id){
		if(panels.size()>0){
			for (int i = 0; i < panels.size(); i++) {
				if(panels.get(i).getData().getId().equals(id)){
					return panels.get(i);
				}
			}
		}
		return null;
	}

	public HTMLPanel getPanel() {
		return panel;
	}

	public void setPanel(HTMLPanel panel) {
		this.panel = panel;
	}

	public EventBus getEventBus() {
		return eventBus;
	}

	public void setEventBus(EventBus eventBus) {
		this.eventBus = eventBus;
		addHandlers();
	}

	
}
