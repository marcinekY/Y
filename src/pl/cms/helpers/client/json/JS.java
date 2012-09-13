package pl.cms.helpers.client.json;

import com.google.gwt.core.client.JavaScriptObject;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;

public class JS extends JavaScriptObject {
	protected JS() {
	}
	
	public final JSONObject getJsonObject(String dataName){
		return new JSONObject(this);
	}
	
	public final JSONValue getData(String dataName){
		return new JsonEntry(new JSONObject(this)).getJsonValue(dataName);
	}
}
