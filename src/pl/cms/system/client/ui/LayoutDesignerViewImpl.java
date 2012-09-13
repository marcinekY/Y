package pl.cms.system.client.ui;

import gwtquery.plugins.draggable.client.DraggableOptions.RevertOption;
import gwtquery.plugins.draggable.client.gwt.DraggableWidget;

import java.util.ArrayList;

import pl.cms.css.client.picker.simple.color.test.ColorPicker;
import pl.cms.helpers.client.json.DataEntry;
import pl.cms.tpllib.client.css.CssDataBase_ttmp;
import pl.cms.tpllib.client.css.CssDataBaseImpl;
import pl.cms.tpllib.client.sections.SectionsTreeView;
import pl.cms.tpllib.client.sections.SectionsView2;
import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import pl.cms.tpllib.client.sections.events.AddSectionEvent;
import pl.cms.tpllib.client.sections.events.AddSectionEventHandler;
import pl.cms.tpllib.client.sections.events.SelectSectionEvent;
import pl.cms.tpllib.client.sections.events.SelectSectionEventHandler;
import pl.cms.tpllib.client.sections.util.DraggableHTMLPanel;

import com.google.gwt.core.client.GWT;
import com.google.gwt.dom.client.Style.Cursor;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Image;
import com.google.gwt.user.client.ui.Widget;

/**
 * Sample implementation of {@link LayoutDesignerView}.
 */
public class LayoutDesignerViewImpl extends Composite implements LayoutDesignerView {

	interface Binder extends UiBinder<Widget, LayoutDesignerViewImpl> {
	}
	
	private static final Binder binder = GWT.create(Binder.class);
	@UiField HTMLPanel panel;
	@UiField SectionsView2 sectionsPanel;
	@UiField FlowPanel controlPanel;
	@UiField SectionsTreeView sectionsTree;
	@UiField Button buttonAddSection;
	@UiField Button buttonRemoveSection;
	@UiField HTMLPanel sectionsWidgetPanel;
//	private SectionAddView sectionsAddBox = new SectionAddView();
//	private SectionsTreeBoxView sectionTreeBox = new SectionsTreeBoxView();
	

	private Presenter listener;
	
	
	
	private EventBus eventBus;
	
	private ArrayList<SectionDataEntry> sections = new ArrayList<SectionDataEntry>();
	private CssDataBaseImpl cssDataBase = new CssDataBaseImpl();
	
	private SectionDataEntry rootSection;

	public LayoutDesignerViewImpl() {
		
//		Window.alert("layout designer");
		initWidget(binder.createAndBindUi(this));

		
//		sectionsAddBox.hide();
//		sectionTreeBox.setPopupPosition(0, 20);
//		sectionTreeBox.show();
	}
	
	
	
	@Override
	public void startView(){
		if(eventBus!=null) {
			sectionsPanel.setEventBus(eventBus);
			sectionsTree.setEventBus(eventBus);
		}
		ColorPicker cp = new ColorPicker();
		sectionsTree.getPanel().add(cp);
		listener.getData("cssbase");
//		rootSection = new SectionEntry();
//		sections.add(rootSection);
//		eventBus.fireEvent(new AddSectionEvent(rootSection));
//		sectionsAddBox.hide();
		
		
		
		
//		Image img = new Image("http://code.google.com/webtoolkit/logo-185x175.png");
//		img.setSize("50px", "50px");
//		Image img2 = new Image("http://code.google.com/webtoolkit/logo-185x175.png");
//		img2.setSize("150px", "150px");
//		VerticalSectionHandler sh = new VerticalSectionHandler();
//		
		Image gwtLogo = new Image("http://code.google.com/webtoolkit/logo-185x175.png");
	    // make the imgae draggable
	    DraggableWidget<Image> draggableLogo = new DraggableWidget<Image>(gwtLogo);
	    // revert the image to its initial position if no drop
	    draggableLogo.setRevert(RevertOption.ON_INVALID_DROP);
	    // ensure that dragging image is above the others during drag operation
	    draggableLogo.setDraggingZIndex(100);
	    // set the cursor during the drag operation
	    draggableLogo.setDraggingCursor(Cursor.MOVE);
	    sectionsWidgetPanel.add(draggableLogo);
	    DraggableHTMLPanel gwtHTML = new DraggableHTMLPanel();
	    gwtHTML.getDraggablePanel().setDisabledDrag(false);
		sectionsWidgetPanel.add(gwtHTML.getDraggablePanel());
//		
//		Image gwtLogo2 = new Image("http://code.google.com/webtoolkit/logo-185x175.png");
//	    // make the imgae draggable
//	    DraggableWidget<Image> draggableLogo2 = new DraggableWidget<Image>(gwtLogo2);
//	    // revert the image to its initial position if no drop
//	    draggableLogo2.setRevert(RevertOption.ON_INVALID_DROP);
//	    // ensure that dragging image is above the others during drag operation
//	    draggableLogo2.setDraggingZIndex(100);
//	    // set the cursor during the drag operation
//	    draggableLogo2.setDraggingCursor(Cursor.MOVE);
//
//	    sectionsWidgetPanel.add(draggableLogo2);
//		sectionsWidgetPanel.add(img);
//		sectionsPanel.getDragController().makeDraggable(sh.getSection(),sh.getHandler());
//		sectionsPanel.addSection(rootSection);
	}
	
	@Override
	public void setData(DataEntry dataEntry){
		if(dataEntry.getName().equals("cssbase")) 
			cssDataBase.setBaseFromJson(dataEntry.getData().isArray());
		return;
	}
	
	public void addSection(SectionDataEntry sectionEntry){
		if(rootSection==null) rootSection = sectionEntry;
		else rootSection.addSection(sectionEntry);
//		sectionsPanel.addSection(sectionEntry);
		sectionsTree.addSection(sectionEntry);
//		sections.add(sectionEntry);
	}
	
	private void setHandlers(){
		eventBus.addHandler(AddSectionEvent.TYPE, new AddSectionEventHandler() {
			
			@Override
			public void onSectionAdd(AddSectionEvent sectionAddEvent) {
				addSection(sectionAddEvent.getSectionData());
			}
		});
		eventBus.addHandler(SelectSectionEvent.TYPE, new SelectSectionEventHandler() {
			@Override
			public void onSectionSelect(SelectSectionEvent sectionSelectEvent) {
				SectionDataEntry selectSE = rootSection.getSelectSection();
				if(selectSE!=null){
					selectSE.setSelect(false);
//					sectionsPanel.refreshPanel(selectSE.getId());
				}
				rootSection.getSection(sectionSelectEvent.getId()).setSelect(true);
//				sectionsPanel.refreshPanel(sectionSelectEvent.getId());
			}
		});
//		Button ok = ;
//		ok.setText("nie ok");
//		sectionsAddBox.getBtnOk().addClickHandler(new ClickHandler() {
//			@Override
//			public void onClick(ClickEvent event) {
//				eventBus.fireEvent(new AddSectionEvent(sectionsAddBox.getSectionEntry()));
//			}
//		});
	}
	
	@Override
	public void setEventBus(EventBus eventBus) {
		this.eventBus = eventBus;
		setHandlers();
	}
	
	private void setComponentsEventBus(){
		if(eventBus!=null) {
			sectionsTree.setEventBus(eventBus);
			sectionsPanel.setEventBus(eventBus);
		}
	}

	@Override
	public void setName(String name) {
		
	}

	@Override
	public void setPresenter(Presenter listener) {
		this.listener = listener;
	}


	@UiHandler("buttonAddSection")
	void onButtonAddSectionClick(ClickEvent event) {
		SectionDataEntry se = new SectionDataEntry();
		SectionDataEntry current = sectionsTree.getSelected();
//		sectionsAddBox.setParentSectionEntry(current);
//		sectionsAddBox.setSectionEntry(se);
//		sectionsAddBox.refreshDataPanel();
//		sectionsAddBox.show();
//		rootSection.addSection(se);
//		rootSection.addSection(se);
//		eventBus.fireEvent(new AddSectionEvent(se));
//		if(sections.size()>0) se.setParentId(sections.get(0).getId());
//		sectionsPanel.addSection(se);
//		SectionPanel sp = new HorizontalSectionPanel();
//		TreeItem selectedItem = getSelectedTreeItem();
//		if(selectedItem!=null){
//			String id = selectedItem.getElement().getAttribute("sId");
//			sectionsPanel.getSection(id).addSection(sp);
//			TreeItem sectionTreeItem = getSectionTreeItem(sp);
//			selectedItem.addItem(sectionTreeItem);
//		} else {
//			sectionsPanel.addSection(sp);
//			TreeItem sectionTreeItem = getSectionTreeItem(sp);
//			sectionsTree.addItem(sectionTreeItem);
//		}
//		
		
	}

	
	
	
}
