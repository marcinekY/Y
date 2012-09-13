package pl.cms.tpllib.client.sections.dndtest;

import com.google.gwt.event.dom.client.MouseDownEvent;
import com.google.gwt.event.dom.client.MouseDownHandler;
import com.google.gwt.event.shared.HandlerRegistration;
import com.google.gwt.user.client.DOM;
import com.google.gwt.user.client.Event;
import com.google.gwt.user.client.Event.NativePreviewEvent;
import com.google.gwt.user.client.Event.NativePreviewHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.FocusWidget;

public class Drag {
	FocusWidget widget;
    private HandlerRegistration registration;
    private HandlerRegistration mouseDownHandler;
    
    public Drag(){
            
    }
    public Drag(FocusWidget widget){
    
            this.widget = widget;
            
    }
    private NativePreviewHandler createNativePreviewHandler(){
            return new NativePreviewHandler() {
                    
                    @Override
                    public void onPreviewNativeEvent(NativePreviewEvent event) {
                            if (event.getNativeEvent().getType().equalsIgnoreCase("mouseup")){
                                    registration.removeHandler(); //Remove the handler
                            }
                            if (event.getNativeEvent().getType().equalsIgnoreCase("mousemove")){

                                    int clientX = event.getNativeEvent().getClientX();
                                    int maxRight= clientX+(widget.getOffsetWidth()/2+5);
                                    int maxLeft = clientX-(widget.getOffsetWidth()/2+5);
                                    int clientY = event.getNativeEvent().getClientY();
                                    int maxDown= clientY+(widget.getOffsetHeight()/2+5);
                                    int maxUP = clientY-widget.getOffsetWidth()/2;

                                    if (Window.getClientWidth()>=maxRight && maxLeft>=0 ){ //Movimiento através de la pantalla
                                            DOM.setStyleAttribute(widget.getElement(), "left", (clientX)- (widget.getOffsetWidth()/2)+ "px");
                                    }else{ //Bloquea el objeto
                                            if (maxLeft<0){
                                                    DOM.setStyleAttribute(widget.getElement(), "left", 5  + "px");
                                            }else{
                                                    DOM.setStyleAttribute(widget.getElement(), "left", Window.getClientWidth()-(widget.getOffsetWidth())-5  + "px"); //Bloqueo  del botón a la derecha de la pantalla
                                            }
                                    }
                                    //Movimiento izquierda
                                    if (Window.getClientHeight()>=maxDown && maxUP >= 0){
                                            DOM.setStyleAttribute(widget.getElement(), "top", ( clientY)- (widget.getOffsetHeight()/2)+ "px");
                                    }else{
                                            if (maxUP<=0){
                                                    DOM.setStyleAttribute(widget.getElement(), "top", 5  + "px");
                                            }else{
                                                    DOM.setStyleAttribute(widget.getElement(), "top", Window.getClientHeight()-(widget.getOffsetHeight())-5  + "px");
                                            }
                                    }
                            }
                            
                    }
            };
            
    
    }
    
    private MouseDownHandler createMouseDownHandler(){
            return new MouseDownHandler() {
                    
                    
                    @Override
                    public void onMouseDown(MouseDownEvent event) {
                            registration = Event.addNativePreviewHandler(createNativePreviewHandler());
                    }
            };
    }
    /**
     * Set drag on or off
     * @param state
     */
    public void setDrag(boolean state){
            if (state){
                    mouseDownHandler= widget.addMouseDownHandler(createMouseDownHandler());
                    
            }else if(registration!=null){
                    mouseDownHandler.removeHandler();
                    
            }
    }

}
