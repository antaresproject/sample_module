DELETE FROM `tbl_widgets_params` WHERE resource='admin';
INSERT INTO `tbl_widgets_params` VALUES 
(202,NULL,3,1,1,'admin','activity_logs','{\"x\":0,\"y\":0,\"disabled\":true,\"width\":7,\"height\":16,\"name\":\"Activity Logs\",\"classname\":\"Antares\\\\Logger\\\\Widgets\\\\ActivityLogsWidget\"}'),
(206,NULL,10,1,1,'admin','graph2','{\"x\":\"6\",\"y\":\"0\",\"disabled\":false,\"width\":\"6\",\"height\":\"10\",\"name\":\"Graph 2\",\"classname\":\"Antares\\\\Modules\\\\SampleModule\\\\UiComponents\\\\GraphBarWidget\"}'),
(208,NULL,8,1,1,'admin','graph1','{\"x\":\"0\",\"y\":\"0\",\"disabled\":false,\"width\":\"6\",\"height\":\"10\",\"name\":\"Graph 1\",\"classname\":\"Antares\\\\Modules\\\\SampleModule\\\\UiComponents\\\\OrdersWidget\"}');
