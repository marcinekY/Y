package pl.cms.css.client;

import java.util.ArrayList;

import pl.cms.helpers.client.json_test.JsonEntry;
import pl.cms.tpllib.client.css.entry.Property;

import com.google.gwt.json.client.JSONArray;

public class CssDataBase {
	private ArrayList<Property> base = new ArrayList<Property>();

	public interface Presenter {
		void getData(String name);
	}
	
	private Presenter listener;
	
	
		
	public CssDataBase(){
		
	}
	
	
	
	public Property getProperty(String name){
		for (int i = 0; i < base.size(); i++) {
			if(base.get(i).getName().equals(name)){
				return base.get(i);
			}
		}
		return null;
	}
	

	private void init(){
		
		
	}

	public ArrayList<Property> getBase() {
		return base;
	}

	public void setBase(ArrayList<Property> base) {
		this.base = base;
	}
	
	public void setBaseFromJson(JSONArray base){
		if(base!=null){
			for (int i = 0; i < base.size(); i++) {
				this.base.add(new Property(new JsonEntry(base.get(i).isObject())));
			}
		}
	}
	
	public void setBaseFromArrayList(ArrayList<JsonEntry> base) {
		if(base!=null){
			for (int i = 0; i < base.size(); i++) {
				if(base.get(i)!=null){
					this.base.add(new Property(base.get(i)));
				}
			};
		}
	}



	public Presenter getListener() {
		return listener;
	}



	public void setListener(Presenter listener) {
		this.listener = listener;
	}
	
	
	
	
}
