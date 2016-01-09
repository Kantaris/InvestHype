using Common.DataAccess;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Data;
using System.IO;
using System.Linq;
using System.Net;
using System.ServiceModel.Syndication;
using System.Web;
using System.Xml;

namespace WebApplication1
{
    /// <summary>
    /// Summary description for getnews
    /// </summary>
    public class getnews : IHttpHandler
    {
        List<Article> aList = new List<Article>();
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
            string sql = "SELECT  article.id,  article.categoryId, category.name as cName,  article.date,  article.title,  article.link,  article.image,  article.summary,  article.sourceId, source.name as sName, article.hyped, article.url FROM article, category, source WHERE article.categoryId = category.id and article.sourceId = source.id and date >= DATE_SUB(@date,INTERVAL 1 DAY) ORDER BY article.hyped DESC LIMIT @toIndex;";
            idb.AddParameter("@date", DateTime.Now);
            idb.AddParameter("@toIndex", toIndex);
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
                    aa.image = HttpUtility.HtmlDecode(dt.Rows[i]["image"].ToString());
                    aa.link = dt.Rows[i]["link"].ToString();
                    aa.pubdate = dt.Rows[i]["date"].ToString();
                    aa.source_id = dt.Rows[i]["sourceId"].ToString();
                    aa.source_name = dt.Rows[i]["sName"].ToString();
                    aa.title = dt.Rows[i]["title"].ToString();
                    aa.title_background = "background-finansnytt";
                    aa.url = dt.Rows[i]["url"].ToString();
                    aList.Add(aa);
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