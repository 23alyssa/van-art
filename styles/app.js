// app.js
// bootstrap script 

const express = require("express")
const path = require("path")

const app = express()

app.use(
  "/js",
  express.static(path.join(_dirname, "node_modules/bootstrap/dist/js"))
)
app.use("/js", express.static(path.join(_dirname, "node_modules/jquery/dist")))

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "browse.php"))
})

app.listen(5000, () => {
  console.log("Listening on port " + 5000)
})
