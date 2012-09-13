package pl.cms.tpllib.client.sections.dndtest;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.shared.HandlerRegistration;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.HasText;
import com.google.gwt.user.client.ui.Widget;

public class Desktop extends Composite {

	private HandlerRegistration registration;
    private static ExampleUiBinder uiBinder = GWT.create(ExampleUiBinder.class);
    @UiField HTMLPanel htmlPanel;
    @UiField Button button;
    boolean drag = false;
    
                     

    interface ExampleUiBinder extends UiBinder<Widget, Desktop>  {
    }

    /**
     * Because this class has a default constructor, it can
     * be used as a binder template. In other words, it can be used in other
     * *.ui.xml files as follows:
     * <ui:UiBinder xmlns:ui="urn:ui:com.google.gwt.uibinder"
     *   xmlns:g="urn:import:**user's package**">
     *  <g:**UserClassName**>Hello!</g:**UserClassName>
     * </ui:UiBinder>
     * Note that depending on the widget that is used, it may be necessary to
     * implement HasHTML instead of HasText.
     */
    public Desktop() {
            
             
            initWidget(uiBinder.createAndBindUi(this));
            //DOM.sinkEvents(image.getElement(),DOM.getEventsSunk(image.getElement()) | Event.MOUSEEVENTS);
            Drag drag = new Drag(button);
            drag.setDrag(true);
            
                    

    }


}
