package pl.cms.css.client.picker.simple.color.test;

import com.google.gwt.event.shared.EventHandler;

public interface IColorChangedHandler extends EventHandler {
	void colorChanged(ColorChangedEvent event);
}
