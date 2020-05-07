<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="listQuery.name"
        placeholder="名字"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >搜索</el-button>
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >添加</el-button>
      <el-button
        v-waves
        :loading="downloadLoading"
        class="filter-item"
        type="primary"
        icon="el-icon-download"
        @click="handleDownload"
      >导出</el-button>
    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="max-width: 1370px;"
      @sort-change="sortChange"
    >
      <el-table-column label="ID" prop="id" sortable align="center" width="80">
        <template slot-scope="{row}">
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="名字" width="120px">
        <template slot-scope="{row}">
          <span class="link-type" @click="handleUpdate(row)">{{ row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="昵称" width="150px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.nickname }}</span>
        </template>
      </el-table-column>
      <el-table-column label="电话" width="120px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.tell }}</span>
        </template>
      </el-table-column>
      <el-table-column label="邮箱" width="250px">
        <template slot-scope="{row}">
          <span>{{ row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column label="加入时间" width="150">
        <template slot-scope="{row}">
          <span>{{ row.crate_time | timeFilter('{y}-{m}-{d} {h}:{i}') }}</span>
        </template>
      </el-table-column>
      <el-table-column label="最后登录时间" prop="last_login_time" sortable="custom" width="150">
        <template slot-scope="{row}">
          <span>{{ row.last_login_time | timeFilter('{y}-{m}-{d} {h}:{i}') }}</span>
        </template>
      </el-table-column>
      <el-table-column label="状态" class-name="status-col" width="100">
        <template slot-scope="{row}">
          <el-tag :type="row.status | statusFilter">{{ row.status | statusNameFilter }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
        align="center"
        width="250px"
        class-name="small-padding fixed-width"
      >
        <template slot-scope="{row,$index}">
          <el-button type="primary" size="mini" @click="handleUpdate(row)">编辑</el-button>
          <el-button
            v-if="row.status!=1"
            size="mini"
            type="success"
            @click="handleModifyStatus(row,1)"
          >启用</el-button>
          <el-button v-if="row.status!=0" size="mini" @click="handleModifyStatus(row,0)">禁用</el-button>
          <el-button
            v-if="row.status!=2"
            size="mini"
            type="danger"
            @click="handleDelete(row,$index)"
          >删除</el-button>
        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="temp"
        label-position="left"
        label-width="100px"
        style="width: 400px; margin-left:50px;"
      >
        <el-form-item v-if="add" label="姓名" prop="name">
          <el-input v-model="temp.name" placeholder="username" />
        </el-form-item>
        <el-form-item v-else label="姓名">
          <el-input v-model="temp.name" :disabled="true" />
        </el-form-item>
        <el-form-item label="昵称" prop="nickname">
          <el-input v-model="temp.nickname" placeholder="nickname" />
        </el-form-item>
        <el-form-item v-if="add" label="初始密码" prop="password">
          <el-input v-model="temp.password" />
        </el-form-item>
        <el-form-item label="电话" prop="tell">
          <el-input v-model="temp.tell" />
        </el-form-item>
        <el-form-item label="邮箱" prop="email">
          <el-input v-model="temp.email" />
        </el-form-item>
        <!-- <el-form-item label="角色">
          <el-select v-model="temp.status" class="filter-item">
            <el-option v-for="item in statusOptions" :key="item" :label="item" :value="item" />
          </el-select>
        </el-form-item>-->
        <el-form-item label="状态">
          <el-select v-model="temp.status" class="filter-item">
            <el-option
              v-for="(item,index) in statusSelectMap"
              :key="index"
              :label="item"
              :value="index"
            />
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取消</el-button>
        <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">确定</el-button>
      </div>
    </el-dialog>

    <el-dialog :visible.sync="dialogPvVisible" title="Reading statistics">
      <el-table :data="pvData" border fit highlight-current-row style="width: 100%">
        <el-table-column prop="key" label="Channel" />
        <el-table-column prop="pv" label="Pv" />
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogPvVisible = false">确定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import {
  fetchList,
  modifyStatus,
  addAddmin,
  updateAddmin
} from '@/api/system'
import waves from '@/directive/waves' // waves directive
import { parseTime, objectDiff } from '@/utils'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination

const calendarTypeOptions = [
  { key: 'CN', display_name: 'China' },
  { key: 'US', display_name: 'USA' },
  { key: 'JP', display_name: 'Japan' },
  { key: 'EU', display_name: 'Eurozone' }
]

// arr to obj, such as { CN : "China", US : "USA" }
const calendarTypeKeyValue = calendarTypeOptions.reduce((acc, cur) => {
  acc[cur.key] = cur.display_name
  return acc
}, {})
const statusMap = ['info', 'success', 'danger']

export default {
  name: 'AdminList',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      return statusMap[status]
    },
    statusNameFilter(status) {
      const statusNameMap = ['禁用', '启用', '已删除']
      return statusNameMap[status]
    },
    typeFilter(type) {
      return calendarTypeKeyValue[type]
    },
    timeFilter(time, cFormat) {
      if (typeof time === 'undefined') {
        return ''
      }
      return parseTime(time, cFormat)
    }
  },
  data() {
    return {
      statusSelectMap: ['禁用', '启用', '已删除'],
      statusDefault: '启用',
      add: true,
      rawData: null,
      diffData: null,
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        name: undefined,
        sort: ''
      },
      importanceOptions: [1, 2, 3],
      calendarTypeOptions,
      temp: {
        name: '',
        nickname: undefined,
        password: '',
        tell: undefined,
        email: undefined,
        role_id: 0,
        status: undefined,
        crate_time: Math.round(new Date().getTime() / 1000)
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑',
        create: '添加'
      },
      dialogPvVisible: false,
      pvData: [],
      rules: {
        name: [
          {
            required: true,
            message: '请填写名字',
            trigger: 'change'
          }
        ],
        password: [
          {
            required: true,
            message: '请填写密码',
            trigger: 'change'
          }
        ],
        tell: [
          {
            message: '长度不能超过11位',
            trigger: 'change',
            max: 11
          }
        ],
        email: [
          {
            type: 'email',
            message: '请输入正确的邮箱地址',
            trigger: 'blur'
          }
        ]
      },
      downloadLoading: false
    }
  },
  computed: {
    ...mapGetters({
      operator: 'name'
    })
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.list
        this.total = response.data.total

        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleModifyStatus(row, status) {
      const params = { id: row.id, status: status }
      modifyStatus(params).then(response => {
        if (response.data === 'success') {
          row.status = status
          this.$message({
            message: '操作成功',
            type: 'success'
          })
        } else {
          this.$message.error('操作失败，请联系客服')
        }
      })
    },
    sortChange(data) {
      const { prop, order } = data
      if (prop === 'id') {
        this.sortByID(order)
      } else if (prop === 'last_login_time') {
        this.sortByLastLoginTime(order)
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id'
      } else if (order === 'descending') {
        this.listQuery.sort = '-id'
      }
      this.handleFilter()
    },
    sortByLastLoginTime(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+last_login_time'
      } else if (order === 'descending') {
        this.listQuery.sort = '-last_login_time'
      }
      this.handleFilter()
    },
    resetTemp() {
      this.temp = {
        name: '',
        nickname: undefined,
        password: '',
        tell: undefined,
        email: undefined,
        role_id: 0,
        status: undefined,
        crate_time: Math.round(new Date().getTime() / 1000)
      }
    },
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate(valid => {
        if (valid) {
          this.temp.operator = this.operator
          addAddmin(this.temp).then(response => {
            this.temp.id = response.data.id
            if (typeof this.temp.status === 'undefined') {
              this.temp.status = response.data.status
            }
            this.list.unshift(this.temp)
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '添加成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    handleUpdate(row) {
      this.rawData = JSON.parse(JSON.stringify(row))
      this.temp = Object.assign({}, row) // copy obj
      this.add = false
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    updateData() {
      this.$refs['dataForm'].validate(valid => {
        if (valid) {
          this.diffData = objectDiff(this.rawData, this.temp)
          this.dialogFormVisible = false
          if (Object.keys(this.diffData).length === 0) {
            this.$notify.info({
              title: '消息',
              message: '没有数据变动，不需要修改',
              duration: 2000
            })
          } else {
            this.diffData['id'] = this.rawData['id']
            updateAddmin(this.diffData).then(() => {
              const index = this.list.findIndex(v => v.id === this.temp.id)
              this.list.splice(index, 1, this.temp)
              this.dialogFormVisible = false
              this.$notify({
                title: '成功',
                message: '修改成功',
                type: 'success',
                duration: 2000
              })
            })
          }
        }
      })
    },
    handleDelete(row, index) {
      this.handleModifyStatus(row, 2)
      this.list.splice(index, 1)
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = [
          'ID',
          '名字',
          '昵称',
          '电话',
          '邮箱',
          '加入时间',
          '最后登录时间',
          '状态'
        ]
        const filterVal = [
          'id',
          'name',
          'nickname',
          'tell',
          'email',
          'crate_time',
          'last_login_time',
          'status'
        ]
        const data = this.formatJson(filterVal)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: '后台管理员'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal) {
      return this.list.map(v =>
        filterVal.map(j => {
          if (j === 'crate_time' || j === 'last_login_time') {
            // 使用this.$options.filters[]方式获取本地过滤器
            var timeFilter = this.$options.filters['timeFilter']
            // 调用本地过滤器
            return timeFilter(v[j], '{y}-{m}-{d} {h}:{i}')
          } else {
            return v[j]
          }
        })
      )
    }
  }
}
</script>
