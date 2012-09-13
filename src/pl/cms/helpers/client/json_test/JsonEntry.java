package pl.cms.helpers.client.json_test;

import java.util.ArrayList;
import java.util.Set;

import com.google.gwt.json.client.JSONArray;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;

public class JsonEntry {
	private JSONObject o;
	
	public JsonEntry(){}
	
	public JsonEntry(JSONObject o){
		this.o = o;
	}
	
//	public void alertDataObType(){
//		JSONValue v = o.get("data");
//		if(v!=null){
//			if(v.isArray()!=null) Window.alert("array");
//			else if(v.isBoolean()!=null) Window.alert("boolean");
//			else if(v.isNull()!=null) Window.alert("null");
//			else if(v.isNumber()!=null) Window.alert("number");
//			else if(v.isObject()!=null) Window.alert("object");
//			else if(v.isString()!=null) Window.alert("string");
//		} else Window.alert("nothing");
//	}
	
	public Set<String> getKeys(){
		if(o!=null){
			return o.keySet(); 
		}
		return null;
	}
	
	public String getString(String key) {
		JSONValue v = getValue(key);
		if (v != null) {
			if (v.isString() != null) {
				return v.isString().stringValue();
			}
			if (v.isNumber() != null) {
				return v.isNumber().toString();
			}
		}
		return null;
	}
	
	public ArrayList<JsonEntry> getArrayList(String key){
		JSONArray jArr = getArray(key);
		ArrayList<JsonEntry> rArr = new ArrayList<JsonEntry>();
		if(jArr!=null){
			for (int i = 0; i < jArr.size(); i++) {
				JsonEntry je = null;
				if(jArr.get(i).isObject()!=null) je = new JsonEntry(jArr.get(i).isObject());
				if(je!=null) rArr.add(je);
			}
		}
		return rArr;
	}
	
	public JSONArray getArray(String key) {
		JSONValue v = getValue(key);
		if(v != null) return v.isArray();
		return null;
	}
	
	public JSONObject getObject(String key){
		JSONValue v = getValue(key);
		if(v!=null) return v.isObject();
		return null;
	}
	
	public JSONValue getValue(String key) {
		if(o!=null){
			JSONValue v = o.get(key);
			return v;
		}
		return null;
	}
	
//	protected String getJsonString(JSONObject o, String key) {
//		JSONValue v = o.get(key);
//		if (v != null) {
//			if (v.isString() != null) {
//				return v.isString().stringValue();
//			}
//			if (v.isNumber() != null) {
//				return v.isNumber().toString();
//			}
//		}
//		return null;
//	}
	
	public JSONValue setValue(String key,JSONValue jsonValue){
		return this.o.put(key, jsonValue);
	}
	
//	public JSONValue setValue(String key,String jsonValue){
//		JSONValue v = 
//		return this.o.put(key, jsonValue);
//	}

	public JSONObject getO() {
		return o;
	}

	protected void setO(JSONObject o) {
		this.o = o;
	}
}
