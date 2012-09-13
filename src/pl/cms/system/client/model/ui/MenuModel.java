package pl.cms.system.client.model.ui;

import java.util.ArrayList;



public class MenuModel {
	private int id;
	private int parentId;
	private int order;
	private ArrayList<MenuItemModel> items = new ArrayList<MenuItemModel>();
	private static String type = "menu";
	private boolean isVertical = false;

	public MenuModel(){
		
	}

	/**
	 * @param id
	 * @param parentId
	 * @param items
	 * @param isVertical
	 */
	public MenuModel(int id, int parentId, ArrayList<MenuItemModel> items,
			boolean isVertical) {
		super();
		this.id = id;
		this.parentId = parentId;
		this.items = items;
		this.isVertical = isVertical;
	}
	
	
	
}
