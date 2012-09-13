package pl.cms.tpllib.client.sections.util;

import java.util.ArrayList;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import pl.cms.tpllib.client.sections.entry.SectionDataEntry.Type;

import com.allen_sauer.gwt.dnd.client.PickupDragController;
import com.allen_sauer.gwt.dnd.client.drop.DropController;
import com.allen_sauer.gwt.dnd.client.drop.FlowPanelDropController;
import com.allen_sauer.gwt.dnd.client.drop.HorizontalPanelDropController;
import com.allen_sauer.gwt.dnd.client.drop.VerticalPanelDropController;
import com.google.gwt.dom.client.Document;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.Panel;
import com.google.gwt.user.client.ui.SimplePanel;
import com.google.gwt.user.client.ui.TreeItem;
import com.google.gwt.user.client.ui.VerticalPanel;

public class SectionTreeItemPanel extends TreeItem {

	private SectionDataEntry data;
	private ArrayList<SectionTreeItemPanel> sections = new ArrayList<SectionTreeItemPanel>();
	
	private Label sectionLabelName = new Label(); 
	
	/**
	 * @wbp.parser.constructor
	 */
	public SectionTreeItemPanel() {
		init();
	}
	
	public SectionTreeItemPanel(SectionDataEntry data){
		if(data!=null){
			this.data = data;
		}
		init();
	}
	
	private void init(){
		if(data==null){
			this.data = new SectionDataEntry();
		}
		refreshItem();
//		if(content==null){
//			data.setName("VertcalSectionPanel");
//			VerticalPanel content = new VerticalPanel();
//			content.add(new Label(data.getName()));
//			setContent(content);
//		}
//		initWidget(content);
		
	}
	
	private void refreshItem(){
//		addItem(getLabel());
		getElement().setAttribute("sId", getData().getId());
		setText(data.getType() + " ID:" + data.getId());
	}
	
	
	
	private Label getLabel(){
		sectionLabelName.setText(data.getName() + " ID:" + data.getId());
		return sectionLabelName;
	}
	
	
	
	public void addSection(SectionTreeItemPanel section){
		addItem(section);
		section.data.setParentId(data.getId());
		sections.add(section);
//		if(section.getOrder()!=-1 && sections.size()>0){
//			ArrayList<SectionPanel> sectionsList = new ArrayList<SectionPanel>();
//			boolean added = false;
//			for(int i=0;i<sections.size();i++){
//				if(sections.get(i).getOrder()>section.getOrder()){
//					added=true;
//					sectionsList.add(section);
//				}
//				sectionsList.add(sections.get(i));
//				if(i==sections.size() && added==false) sectionsList.add(section);
//			}
//			sections = sectionsList;
//		}
	}
	
	public SectionTreeItemPanel getSection(String id){
		if(sections!=null){
			for(int i=0;i<sections.size();i++){
				if(sections.get(i).getData().getId().equals(id)){
					//tu zmienic, nazwa nie moze byc ustawiana tutaj
					sections.get(i).getData().setName(sections.get(i).getData().getName()+sections.get(i).getData().getId());
					return sections.get(i);
				}
				if(sections.get(i).getSection(id)!=null) {
					return sections.get(i).getSection(id);
				}
			}
		}
		return null;
	}
	

	
	
	
//	public void refreshChildrenOrders(){
//	}
	
	

	
	
	
//		
//	public void setDragController(PickupDragController dragController){
//		this.dragController = dragController;
//		if(this.dragController!=null){
//			
//			if (content instanceof FlowPanel){
//				DropController dropController = new FlowPanelDropController((FlowPanel) content);
//				this.dragController.registerDropController(dropController);
//			} else if (content instanceof VerticalPanel) {
//				DropController dropController = new VerticalPanelDropController((VerticalPanel) content);
//				this.dragController.registerDropController(dropController);
//			} else if (content instanceof HorizontalPanel) {
//				DropController dropController = new HorizontalPanelDropController((HorizontalPanel) content);
//				this.dragController.registerDropController(dropController);
//			}
//		}
//	}
//	
//	public PickupDragController getDragController() {
//		return dragController;
//	}
//	
//	public void addClass(String className) {
//		content.addStyleName(className);
//		classNames.add(className);
//	}
//	
//	public void removeClass(String className) {
//		content.removeStyleName(className);
//		classNames.remove(className);
//	}
//	
//	public void refreshContentClass(){
//		if(data.getClassNames().size()>0){
//			for(int i=0;i<data.getClassNames().size();i++){
//				content.addStyleName(data.getClassNames().get(i));
//			}
//		}
//	}
	
//	public Panel getContent() {
//		return content;
//	}
//
//	public void setContent(Panel content) {
//		this.content = content;
//		refreshContentClass();
//	}

	public SectionDataEntry getData() {
		return data;
	}

	public void setData(SectionDataEntry se) {
		this.data = se;
	}
}
