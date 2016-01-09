using Common.DataAccess;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Web;

namespace WebApplication1
{
    /// <summary>
    /// Summary description for nyheter
    /// </summary>
    public class nyheter : IHttpHandler
    {
        List<Article> aList = new List<Article>();
        int[] nyemIndexes = new int[4] {1, 6, 7, 13 };
        public void ProcessRequest(HttpContext context)
        {
            string from = context.Request.Params["from"];
            string to = context.Request.Params["to"];
            int toIndex = 49;
            int fromIndex = 0;
            if (to != null && to.Length > 0)
            {
                Int32.TryParse(to, out toIndex);
            }
            if (from != null && from.Length > 0)
            {
                Int32.TryParse(from, out fromIndex);
            }
            IDBOperator idb = DBOperator.GetInstance();
            DataTable nyem = new DataTable();
            if (fromIndex == 0)
            {
                string nysql = "SELECT  article.id, article.localimage, article.categoryId, category.name as cName, category.background, article.date,  article.title,  article.link,  article.image,  article.summary,  article.sourceId, source.name as sName, article.hyped, article.url FROM article, category, source WHERE article.categoryId = category.id and article.sourceId = source.id and article.active > 0 ;";
                nyem = idb.ReturnDataTable(nysql);
            
            }
            string sql = "SELECT  article.id,  article.categoryId, article.localimage, category.name as cName, category.background,  article.date,  article.title,  article.link,  article.image,  article.summary,  article.sourceId, source.name as sName, article.hyped, article.url FROM article, category, source WHERE article.categoryId = category.id and article.sourceId = source.id and date >= DATE_SUB(@date,INTERVAL 1 DAY) ORDER BY article.hyped DESC LIMIT @toIndex;";
            idb.AddParameter("@date", DateTime.Now);
            idb.AddParameter("@toIndex", toIndex - nyem.Rows.Count);
            DataTable dt = idb.ReturnDataTable(sql);
            if (dt.Rows.Count > 0)
            {
                for (int i = fromIndex; i < dt.Rows.Count; i++)
                {
                    Article aa = new Article();
                    aa.category_id = dt.Rows[i]["categoryId"].ToString();
                    aa.category_name = dt.Rows[i]["cName"].ToString();
                    aa.description = dt.Rows[i]["summary"].ToString();
                    aa.hyped = dt.Rows[i]["hyped"].ToString();
                    aa.id = dt.Rows[i]["id"].ToString();
                    aa.image = dt.Rows[i]["image"].ToString();
                    aa.localimage = dt.Rows[i]["localimage"].ToString();
                    aa.link = dt.Rows[i]["link"].ToString();
                    aa.pubdate = dt.Rows[i]["date"].ToString();
                    aa.source_id = dt.Rows[i]["sourceId"].ToString();
                    aa.source_name = dt.Rows[i]["sName"].ToString();
                    aa.title = dt.Rows[i]["title"].ToString();
                    aa.title_background = dt.Rows[i]["background"].ToString();
                    aa.url = dt.Rows[i]["url"].ToString();
                    aList.Add(aa);
                }
            }
            if (nyem.Rows.Count > 0)
            {
                for (int i = 0; i < nyem.Rows.Count; i++)
                {
                    Article aa = new Article();
                    aa.category_id = nyem.Rows[i]["categoryId"].ToString();
                    aa.category_name = nyem.Rows[i]["cName"].ToString();
                    aa.description = nyem.Rows[i]["summary"].ToString();
                    aa.hyped = nyem.Rows[i]["hyped"].ToString();
                    aa.id = nyem.Rows[i]["id"].ToString();
                    aa.image = HttpUtility.HtmlDecode(nyem.Rows[i]["image"].ToString());
                    aa.localimage = nyem.Rows[i]["localimage"].ToString();
                    aa.link = nyem.Rows[i]["link"].ToString();
                    aa.pubdate = nyem.Rows[i]["date"].ToString();
                    aa.source_id = nyem.Rows[i]["sourceId"].ToString();
                    aa.source_name = nyem.Rows[i]["sName"].ToString();
                    aa.title = nyem.Rows[i]["title"].ToString();
                    aa.title_background = nyem.Rows[i]["background"].ToString();
                    aa.url = nyem.Rows[i]["url"].ToString();
                    aList.Insert(nyemIndexes[i], aa);
                }
            }
            string output = "";
            context.Response.ContentType = "application/json";
            context.Response.AppendHeader("Access-Control-Allow-Origin", "*");
            output = JsonConvert.SerializeObject(aList);
            context.Response.Write(output);
        }

        public bool IsReusable
        {
            get
            {
                return false;
            }
        }
    }
}