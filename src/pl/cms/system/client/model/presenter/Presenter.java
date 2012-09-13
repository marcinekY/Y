package pl.cms.system.client.model.presenter;

import pl.cms.helpers.client.json.DataEntry;

public interface Presenter {
	
	public interface Activity {
		void getData(String name);
	}
	public interface View {
		void setData(DataEntry data);
		void getData(String name, Object view);
	}
	
	void setListener(Activity listener);
}
